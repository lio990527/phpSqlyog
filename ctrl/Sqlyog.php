<?php 

class Sqlyog extends Controller{
	
	private $config = CONFPATH . 'database.ini';

	public function configs(){
		$configs = Tini::readIni($this->config);
		$default = $configs['default']; unset($configs['default']);
		array_key_exists($default, $configs) OR $default = array_keys($configs)[0];
		$this->print_json('1', ['default' => $default, 'config' => $configs]);
	}
	
	public function new($name){
		$configs = Tini::readIni($this->config);
		$newname = $this->unq_name($name, $configs);
		$configs[$newname] = [
			'host' => '127.0.0.1',
			'port' => '3306',
			'user' => 'root',
			'pass' => '',
			'default' => '',
			'selected' => '1',
		];
		$configs['default'] = $newname;
		$res = Tini::writeIni($this->config, $configs);
		$this->print_json('1', $res, 'create success');
	}
	
	public function copy($name){
		$configs = Tini::readIni($this->config);
		if (! array_key_exists($name, $configs)) {
			$this->print_json('0', new stdClass(), 'unknown config');
		}
		
		$newname = $name .'_copy';
		$configs[$newname] = $configs[$name];
		$configs['default'] = $newname;
		$res = Tini::writeIni($this->config, $configs);
		$this->print_json('1', $res, 'copy success');
	}

	public function save($name){
		$configs = Tini::readIni($this->config);
		
		$configs[$name] = $this->request->post();
		$configs['default'] = $name;
		
		$res = Tini::writeIni($this->config, $configs);
		$this->print_json('1', $res, 'save success');
	}
	
	public function rename($name){
		$configs = Tini::readIni($this->config);
		if (! array_key_exists($name, $configs)) {
			$this->print_json('0', new stdClass(), 'unknown config');
		}
		
		$names = array_keys($configs);
		$names[array_search($name, $names)] = $this->request->get('newname');
		$configs = array_combine($names, array_values($configs));
		$configs['default'] = $this->request->get('newname');
		$res = Tini::writeIni($this->config, $configs);
		$this->print_json('1', $res, 'rename success');
	}
	
	/**
	 * 删除配置
	 * @param string $name
	 */
	public function del($name){
		$configs = Tini::readIni($this->config);
		if (! array_key_exists($name, $configs)) {
			$this->print_json('0', new stdClass(), 'unknown config');
		}
		
		unset($configs[$name]);
		$res = Tini::writeIni($this->config, $configs);
		$this->print_json('1', $res, 'delete success');
	}
	
	public function tables(){
		$conn = Tmysql::factory($this->request->get('name'));
		$conn->select_db($this->request->get('db'));
		$tables = $conn->show_tables();
		
		$this->output->data('tables', $tables);
	}
	
	private function unq_name($name, $list){
		if(array_key_exists($name, $list)){
			$name = preg_match('/_(\d+)$/', $name, $match) ? str_replace($match[1], intval($match[1]) + 1, $name) : ($name . '_1');
			return $this->unq_name($name, $list);
		}
		return $name;
	}
}