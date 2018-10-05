<?php
include __DIR__ . "/config.php";
include __DIR__ . "/core/index.php";
header("Cache-Control: public, max-age=86400");
header("Content-Type: text/html; charset=utf-8");

function view($file, $data){
	if(is_array($data)){
		foreach($data as $k => $v){
			$$k = isset($v) ? $v : null;
		}
	}
		
	if(is_array($file)){
		foreach($file as $f){
			$f = __DIR__ . "/views/{$f}.php";
			if(file_exists($f)){
				include($f);
			}
		}
	}else{
		$f = __DIR__ . "/views/{$file}.php";
		if(file_exists($f)){
			include($f);
		}
	}

}


$param = isset($_GET["_"]) ? $_GET["_"] : "";

$param = trim($param, "/");
$param = rtrim($param, "/");
$param = str_replace(array("/", "."), "-", $param);
if($param == ""){
	$param = "index";
}

if(file_exists(strtolower(dirname(__FILE__)."/controllers/". $param .".php"))){
	$url = strtolower(dirname(__FILE__)."/controllers/". $param .".php");

}else{
	$url = strtolower(dirname(__FILE__)."/controllers/error.php");
	http_response_code(404);

}
ob_start();
	include ($url);;
	$content = ob_get_contents();
ob_end_clean();

foreach($replace_vars as $k => $v){
	$content = str_ireplace("%{$k}%", $v, $content);
}
echo $content;
?>