<?php 


class Home extends Controller{
	
	public function index(){
		var_dump('mtf!',func_get_args());
		
		$data = ['a'=>'1'];
		$this->output->view('default', $data);
		$this->output->data('page', 1);
		$this->output->data('limit', 20);
	}
}