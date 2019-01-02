<?php 

class Connect extends Controller{
	
	
	public function index(){
		$conf = $this->request->post();
		$name = $conf['name']; unset($conf['name']);
		if (! empty($name)) {
			$configs = Tini::readIni('database.ini');
			if (array_key_exists('change', $conf)) {
				unset($conf['change']);
				$configs[$name] = $conf;
			}
			$configs['default'] = $name;
			Tini::writeIni('database.ini' , $configs);
			
			$name = md5($name);
			$temp = 'tmp_' . $name . '.ini';
			Tini::writeIni($temp , $conf);
		}
		
		$this->output->data('name', $name);
	}
	
	public function test(){
		$conf = $this->request->post();
		$name = $conf['name']; unset($conf['name']);
		
		$database = new Database();
		$database->connect($conf['host'], $conf['port'], $conf['user'] , $conf['pass'], $conf['default']);
		$error = $database->error();
		if (! empty($error)) {
			$this->print_json('0', false, $error['error']);
		}
		
		$configs = Tini::readIni('database.ini');
		$config = $configs[$name];
		ksort($conf); ksort($config);
		
		$data = 'N';
		if(md5(json_encode($conf)) !== md5(json_encode($config))){
			$data = 'Y';
		}
		
		$this->print_json('1', $data, 'connect success');
	}
	
	public function table(){
		$name = $this->request->get('name');
		$dbs = array();
		if (! empty($name)) {
			$conn = Tmysql::factory($name);
			if (! empty($this->request->get('db'))) {
				$conn->select_db($this->request->get('db'));
				$tables = ['tables' => $conn->show_tables()];

				$this->output->view('tables', $tables);
				$this->output->print(true);
			} else {
				$dbs = empty($conn->conf['default']) ? $conn->show_dbs() : array(['Database'=>$conn->conf['default']]);
			}
		}

		$this->output->data('name', $name);
		$this->output->data('dbs', $dbs);
	}
	
	public function info(){
		$name = $this->request->get('name');
		$db = $this->request->get('db');
		if (! empty($name) && !empty($db)) {
			$conn = Tmysql::factory($name);
			if(empty($this->request->get('table'))){
				$info = $conn->show_info($db);
				$this->output->data('infos', $info);
			}else{
				$conn->select_db($db);
				$info = $conn->show_cols($this->request->get('table'));
				$this->output->data('columns', $info);
			}
		}
		
		$this->output->view('info');
		$this->output->print(true);
	}
	
	public function data(){
		$name = $this->request->get('name');
		$db = $this->request->get('db');
		$table = $this->request->get('table');
		$result = array('data' => []);
		if (! empty($name) && ! empty($table)) {
			$sql = "SELECT * FROM {$table}";
			$conn = Tmysql::factory($name);
			empty($db) OR $conn->select_db($db);

			$result['order'] = $this->request->post('order', '');
			$result['sort']  = $this->request->post('sort', 'ASC');
			if(!empty($result['order'])){
				$sql .= " ORDER BY {$result['order']} {$result['sort']}";
			}
			if (empty($this->request->post('export'))) {
				$page = $this->request->post('page', 1);
				$size = $this->request->post('limit', 50);
				$sql_count = 'SELECT COUNT(1) as sum ' . substr($sql, stripos($sql, ' from '));
				$obj_count = $conn->query($sql_count);
				if ($obj_count !== false) {
					$res_count = $obj_count->fetch_array();
					$start = ($page - 1) * $size;
					$sql .= " LIMIT {$start},{$size}";
					
					$result['page']['num'] = $page;
					$result['page']['prev'] = $page - 1;
					$result['page']['next'] = $page + 1;
					$result['page']['size'] = $size;
					$result['page']['max'] = ceil(intval($res_count['sum']) / $size);
				}
			}
			
			$result['data']['cols'] = $conn->show_cols($table);
			
			$res_object = $conn->query($sql);
			$result['data']['rows'] = $conn->result_list($res_object);
			if(!empty($this->request->post('export'))){
				$tbl_name = '';
				preg_match('/from\s*`?(\w+)`?/i', $sql, $tbl_name);
				$tbl_name = isset($tbl_name[1]) ? $tbl_name[1] : 'anytable';
				switch ($this->request->post('export')){
					case 1:
						Texport::sql($result['data']['rows'], $tbl_name);
						break;
					case 2:
						Texport::csv($result['data']['rows'], $tbl_name);
						break;
					case 3:
						Texport::json($result['data']['rows'], $tbl_name);
						break;
				}
			}
		}

		$this->output->data('name', $name);
		$this->output->data('db', $db);
		$this->output->data('table', $table);
		$this->output->data('result', $result);
		$this->output->view('data');
		$this->output->print(true);
	}
	
	public function query(){
		$this->output->data('name', $this->request->get('name'));
	}
	
	public function result(){
		$name = $this->request->get('name');
		$results = array('count' => 0, 'success' => 0, 'fail' => 0);
		$searchs = array();
		$conn = Tmysql::factory($name);
		if(!empty($conn->conf['default'])){
			$infos = $conn->show_info($conn->conf['default']);
			$this->output->data('infos', $infos);
		}
		if (! empty($this->request->post('sql')) && ! empty($name)) {
			$sqls = array_filter(explode('__', $this->request->post('sql')));
			$index_search = 1;
			foreach ($sqls as $sql){
				if(preg_match('/^(update|delete|insert)/i', $sql)) {
					$begin_time = microtime(true);
					$intRes = $conn->query($sql);
					$results['detail'][$sql]['state'] = $intRes;
					$results['detail'][$sql]['affect'] = $conn->affected_rows;
					$results['detail'][$sql]['time'] = round(microtime(true) - $begin_time, 3);
					$results['count']++;
					if($intRes > 0){
						$results['success']++;
					}else{
						$results['detail'][$sql]['errno'] = $conn->errno;
						$results['detail'][$sql]['error'] = $conn->error;
						$results['fail']++;
					}
				}else if(preg_match('/^select/i', $sql)){
					$result = array(
						'data' => [],
						'sql' => $sql,
					);

					$result['order'] = $this->request->post('order', '');
					$result['sort']  = $this->request->post('sort', 'ASC');
					if(!empty($result['order'])){
						$sql = stripos($sql, 'limit') ? str_ireplace('limit', "ORDER BY {$result['order']} {$result['sort']} LIMIT", $sql) : $sql." ORDER BY {$result['order']} {$result['sort']}";
					}
					if (stripos($sql, 'limit') === false && empty($this->request->post('export'))) {
						$page = $this->request->post('page', 1);
						$page = $this->request->post('prev', $page);
						$page = $this->request->post('next', $page);
						$size = $this->request->post('limit', 50);
						$sql_count = 'SELECT COUNT(1) as sum ' . substr($sql, stripos($sql, ' from '));
						$obj_count = $conn->query($sql_count);
						if ($obj_count !== false) {
							$res_count = $obj_count->fetch_array();
							$start = ($page - 1) * $size;
							$sql .= " LIMIT {$start},{$size}";

							$result['page']['num'] = $page;
							$result['page']['prev'] = $page - 1;
							$result['page']['next'] = $page + 1;
							$result['page']['size'] = $size;
							$result['page']['max'] = ceil(intval($res_count['sum']) / $size);
						}
					}
					$begin_time = microtime(true);
					$res_object = $conn->query($sql);
					$results['count']++;
					$results['detail'][$sql]['state'] = $conn->sqlstate === '00000' ? 1 : 0;
					$results['detail'][$sql]['affect'] = $conn->affected_rows;
					$results['detail'][$sql]['time'] = round(microtime(true) - $begin_time, 3);
					if($res_object === false){
						$results['fail']++;
						$results['detail'][$sql]['errno'] = $conn->errno;
						$results['detail'][$sql]['error'] = $conn->error;
					}else{
						$results['success']++;
						while ($row = $res_object->fetch_assoc()){
							if(!array_key_exists('cols', $result['data'])){
								$result['data']['cols'] = array_keys($row);
							}
							$result['data']['rows'][] = $row;
						}
						if(!empty($this->request->post('export'))){
							$tbl_name = '';
							preg_match('/from\s*`?(\w+)`?/i', $sql, $tbl_name);
							$tbl_name = isset($tbl_name[1]) ? $tbl_name[1] : 'anytable';
							switch ($this->request->post('export')){
								case 1:
									Texport::sql($result['data']['rows'], $tbl_name);
									break;
								case 2:
									Texport::csv($result['data']['rows'], $tbl_name);
									break;
								case 3:
									Texport::json($result['data']['rows'], $tbl_name);
									break;
							}
						}
						$searchs[$index_search] = $result;
						$index_search++;
					}
				}else{
					//$arrResult['result'][$strSql] = $objConn['s']->query($strSql);
				}
			}
		}

		$this->output->data('name', $name);
		$this->output->data('searchs', $searchs);
		$this->output->data('results', $results);
	}
}