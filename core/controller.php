<?php
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
	 * @param int $status
	 * @param mixed $data
	 * @param string $msg
	 */
	protected function print_json($status, $data, $msg = ''){
		$this->output->print_json($status, $msg, $data);
	}
	
}