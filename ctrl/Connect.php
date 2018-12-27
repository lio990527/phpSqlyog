<?php 

class Connect extends Controller{
	
	public function _onload()
	{}
	
	public function index(){
		$name = $this->request->post('name');
		$temp = 'tmp_' . md5($name);
		$conf = $this->request->post(['host', 'port', 'user', 'pass', 'default']);

		Tini::writeIni(CONFPATH . $temp . '.ini', $conf);
		
		header("location:main.php?name={$name}&db={$conf['default']}");
	}
	
	
}