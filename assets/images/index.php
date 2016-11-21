<?
$dh = opendir(dirname(__FILE__));
while (false !== ($filename = readdir($dh))) {
    $files[] = $filename;
}
sort($files);
$arr = array();
foreach ($files as $f) { 
	if($f AND !strpos(' '.$f, '!') AND (strpos($f, '.jpg') OR strpos($f, '.png') OR strpos($f, '.jpeg') OR strpos($f, '.gif')) AND !strpos($f, '.php')  AND !is_dir($f)){
		$arr[] = $f;
	} 
}


$bgcnt = count($arr);