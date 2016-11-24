<?php
include "_config.php";
define("WALL_ID", WALL_ID);
function getPosts(){
	$url = 'https://api.vk.com/method/wall.get';
	$params = array(
		'owner_id' => WALL_ID,
		'count' => 100,
		'v' => '5.37'
	);
	$response = file_get_contents($url, false, stream_context_create(array(
		'http' => array(
			'method'  => 'POST',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => http_build_query($params)
		)
	)));
	$response = json_decode($response, 1);
	$response = $response['response']['items'];
	return $response;
}

$cache_url = dirname(__FILE__).'/data/posts.json';
if(!file_exists($cache_url) || time() - filemtime($cache_url) > 86400){
	$data = getPosts();
	$f = fopen($cache_url, 'c');
	fwrite($f, json_encode($data));
	fclose($f);
}