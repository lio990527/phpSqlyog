<?php

class Tini
{

	public static function readIni($file, $type = true)
	{
		if (! is_file(CINIPATH.$file)) return array();
		return parse_ini_file(CINIPATH. $file, $type);
	}

	public static function writeIni($file, $content = array())
	{
		$ini = ';ini config' . PHP_EOL;
		foreach ($content as $name => $value) {
			if (is_array($value)) {
				$ini .= "[{$name}]" . PHP_EOL;
				foreach ($value as $k => $v) {
					$ini .= "{$k} = '{$v}'" . PHP_EOL;
				}
			} else {
				$ini .= "{$name} = '{$value}'" . PHP_EOL;
			}
			$ini .= PHP_EOL;
		}

		if (! is_dir(dirname(CINIPATH . $file))) {
			mkdir(dirname(CINIPATH . $file), 0700) or die('path create error');
		}

		$file = fopen(CINIPATH . $file, 'w');
		fwrite($file, $ini) or die('file save error');
		return true;
	}
}