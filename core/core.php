<?php

define('COREPATH', APPPATH . 'core/');
define('CTRLPATH', APPPATH . 'ctrl/');
define('LIBPATH', APPPATH . 'lib/');
define('CONFPATH', LIBPATH . 'conf/');
define('VIEWPATH', APPPATH . 'view/');

require_once COREPATH . 'autoload.php';
require_once COREPATH . 'controller.php';
/**
 * @var Trequest
 */
$request = new Trequest();

$control = $request->get('ctrl');
$control = explode('/', $control);

$class_name = ucfirst(array_shift($control));
$methd_name = array_shift($control);
$ctrol_path = CTRLPATH.$class_name.'.php';

!empty($methd_name) OR $methd_name = 'index';
if(is_file($ctrol_path)){
	require_once $ctrol_path;
	try {
		$method = new ReflectionMethod($class_name, $methd_name);
		
		/**
		 * 
		 * @var Controller $controller
		 */
		$controller = new $method->class;
		call_user_func_array(array($controller, $method->name), $control);
		
		$view_name = lcfirst($method->class) . '/'. $method->name;
		if(is_file(VIEWPATH . $view_name . ".php")){
			$controller->output->view($view_name);
		}
		$controller->output->print();
	} catch (Exception $e) {
		die('error:'.$e->getMessage());
	}
}
