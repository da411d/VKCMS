<?php
header('content-type: text/js');

$dh = opendir(dirname(__FILE__).'/');
$files = [];
while (false !== ($filename = readdir($dh))) {
	$files[] = $filename;
}
sort($files);

foreach ($files as $f) { 
	if($f AND !strpos(' '.$f, '!') AND strpos($f, '.js') AND !strpos($f, '.php')  AND !is_dir(dirname(__FILE__).'/'.$f)){
		include_once dirname(__FILE__).'/'.$f;
	} 
}