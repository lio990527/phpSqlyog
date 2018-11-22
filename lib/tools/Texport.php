<?php
ini_set('memory_limit', '2048M');
class Texport
{

	public static function csv($arr, $name = 'table_name', $title = array())
	{
		$sub_name = date('ymdHis');
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename={$name}_{$sub_name}.csv");
		if(!empty($arr)){
			!empty($title) OR $title = array_keys(current($arr));
			array_unshift($arr, $title);
			foreach ($arr as $v){
				echo '"'.iconv('UTF-8', 'GBK', str_replace(array("\r","\n"), array('\r','\n'), implode('","', $v))).'"' . PHP_EOL;
			}
		}
		exit;
	}

	public static function sql($arr, $name = 'table_name')
	{
		$sub_name = date('ymdHis');
		header('Content-Type: application/octet-stream');
		header("Content-Disposition: attachment; filename={$name}_{$sub_name}.sql");
		if(!empty($arr)){
			foreach ($arr as $v){
				$col_names = str_replace(array("\r","\n"), array('\r','\n'), implode('`,`', array_keys($v)));
				$col_value = str_replace(array("\r","\n"), array('\r','\n'), implode('","', $v));
				echo "INSERT INTO `{$name}` (`{$col_names}`) VALUES (\"{$col_value}\");" . PHP_EOL;
			}
		}
		exit;
	}

	public static function xml()
	{
		;
	}
	
	public static function json($arr, $name = 'table_name'){
		$sub_name = date('ymdHis');
		header('Content-Type: application/octet-stream');
		header("Content-Disposition: attachment; filename={$name}_{$sub_name}.json");
		if(!empty($arr)){
			echo json_encode($arr);
		}
		exit;
	}
}