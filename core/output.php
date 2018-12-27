<?php 

class Output {
	
	/**
	 * @var string
	 */
	private $content;
	
	/**
	 * @var array
	 */
	private $vars;
	
	public function data($key, $value){
		$this->vars[$key] = $value;
	}
	
	public function view($name, $data = []){
		$name = VIEWPATH . "{$name}.php";
		is_file($name) OR die('view not found');
		!empty($data) OR $data = $this->vars;
		extract($data);
		ob_start();
		include($name);
		$this->append(ob_get_contents());
		ob_clean();
	}
	
	public function append($info) {
		$this->content .= $info;
	}
	
	public function print(){
		echo $this->content;
	}
}