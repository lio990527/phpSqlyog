<?php 

class Output {
	
	/**
	 * @var string
	 */
	private $content;
	
	/**
	 * @var array
	 */
	private $vars = [];
	
	public function data($key, $value){
		$this->vars[$key] = $value;
	}
	
	public function view($name, $data = []){
		$view_name = VIEWPATH . "{$name}.php";
		is_file($view_name) OR die('view not found:' . $view_name);
		!empty($data) OR $data = $this->vars;
		extract($data);
		ob_start();
		include($view_name);
		$this->append(ob_get_contents());
		ob_clean();
	}
	
	public function append($info) {
		$this->content .= $info;
	}
	
	public function print($exit = false){
		echo $this->content;
		! $exit OR exit;
	}
	
	/**
	 * 输出json
	 * @param int $status 
	 * @param string $message
	 * @param array $data
	 */
	public function print_json($status, $message = '', $data = []){
		$response = [
			'status' => $status,
			'data' => empty($data) ? $this->vars : $data,
			'message' => $message,
		];
		
		echo json_encode($response);
		exit;
	}
}