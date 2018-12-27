<?php

class Ajax extends Controller
{

	private $conn;

	public function list(){
		
	}
	
	
	public function connect($name)
	{
		$conf = $this->request->post(['host', 'user', 'pass', 'default', 'port']);
		$dtbs = new Database();
		$dtbs->connect($conf['host'], $conf['port'], $conf['user'] , $conf['pass'], $conf['default']);
		$error = $dtbs->error();
		if (! empty($error)) {
			$this->print_json('0', false, $error['error']);
		}
		// $conn = Tmysql::connect($conf);
		$this->print_json('1', true, 'connect success');
	}
	
	
}
?>