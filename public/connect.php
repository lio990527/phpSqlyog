<?php 
require_once 'index.php';
// $conn = Tini::readIni(CONFPATH.'database.ini');
$post = $_POST;
$name = $_POST;


// $flag = false;
// array_key_exists($post['name'], $conn) OR die('unknown db');
// foreach ($conn[$post['name']] as $key => &$val){
// 	if($post[$key] !== $val){
// 		$flag = true;
// 		$val = $post[$key];
// 	}
// }
// if($post['origin_name'] !== $post['name']){
// 	$flag = true;
// 	$key_new = explode('|', str_replace($post['origin_name'], $post['name'], implode('|', array_keys($conn))));
// 	$conn = array_combine($key_new, $conn);
// }
// if($conn['default'] !== $post['name']){
// 	$flag = true;
// 	$conn['default'] = $post['name'];
// }
// if($flag){
// 	Tini::writeIni(CONFPATH.'database.ini', $conn);
// }

header("location:main.php?db={$post['name']}");
?>