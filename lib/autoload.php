<?php 

function my_autoload($name){
	$file_name = find_file($name);
	!empty($file_name) OR die($name.' not find');
	require_once $file_name;
}

function find_file($name, $path = ''){
	$filename = LIBPATH.$path.$name.'.php';
	if(file_exists($filename)){
		return $filename;
	}else if(is_dir(LIBPATH.$path)){
		$obj = dir(LIBPATH.$path);
		while (($p = $obj->read()) !== false){
			if($p === '.' || $p === '..') continue;
			if(is_file(LIBPATH.$path.$p)) continue;
			if(is_dir(LIBPATH.$path.$p)) return find_file($name, $path.$p.'/');
		}
	}else{
		return '';
	}
}

spl_autoload_register('my_autoload');