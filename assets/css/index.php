<?php
header('content-type: text/css');

$dh = opendir(dirname(__FILE__).'/');
$files = [];
while (false !== ($filename = readdir($dh))) {
	$files[] = $filename;
}
sort($files);

foreach ($files as $f) { 
	if(
		$f && 
		strpos($f, '!') === false && 
		strpos($f, '.css') && 
		!strpos($f, '.php') && 
		!is_dir(dirname(__FILE__).'/'.$f)	
	){
		include_once dirname(__FILE__).'/'.$f;
	} 
}