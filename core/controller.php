<?php
require_once COREPATH . 'output.php';
abstract class Controller {
	
	/**
	 * 
	 * @var Trequest
	 */
	protected $request;
	
	/**
	 * @var Output
	 */
	public $output;
	
	public function __construct(){
		$this->request = new Trequest();
		$this->output = new Output();
		$this->__onload();
	}
	
	function __onload(){}
	
	/**
	 * 
	 * @param int $code
	 * @param mixed $data
	 * @param string $msg
	 */
	protected function print_json($code, $data, $msg = ''){
		$response = [
			'code' => $code,
			'data' => $data,
			'message' => $msg,
		];
		
		echo json_encode($response);
		exit;
	}
	
}