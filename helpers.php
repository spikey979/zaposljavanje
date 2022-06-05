<?php

function custom_log() {
    //$file = 'dump.txt';
    $file = '/Users/kiki/www/Pproject/zaposljavanje/dump.txt';
	
	$arr = func_get_args();
	$log = "";
	foreach(func_get_args() as $arg){
		if(!empty($log)){$log.="\n";}
		$tmp = var_export($arg, true);
		$tmp = trim($tmp, "'");//remove single quote which was added by var_export()
		$log.= $tmp;
	}

	//@file_put_contents($file, date('Y-m-d H:i:s').' '.utf8_encode($log)."\n", FILE_APPEND);
	@file_put_contents($file, utf8_encode($log)."\n", FILE_APPEND);
	unset($tmp);
	unset($log);
}