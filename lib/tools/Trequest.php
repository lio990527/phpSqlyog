<?php 

class Trequest{
	
	public function get($key = null, $default = null){
		return self::get_val($key, $_GET, $default);
	}
	
	public function post($key = null, $default = null){
		return self::get_val($key, $_POST, $default);
	}
	
	public function request($key = null, $default = null){
		return self::get_val($key, $_REQUEST, $default);
	}
	
	public function server($key = null, $default = null){
		return self::get_val($key, $_SERVER, $default);
	}
	
	public function cookie($key = null, $default = null){
		return self::get_val($key, $_COOKIE, $default);
	}
	
	private function get_val($key, array $array, $default){
		return empty($key) 
		? $array 
		: ((is_array($key) 
			? array_combine($key, array_map(function($k) use ($array){
				return array_key_exists($k, $array) ? $array[$k] : null;
			}, $key)) 
			: (array_key_exists($key, $array) ? $array[$key] : $default)));
		
	}
}
