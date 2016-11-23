<?php
define("WALL_ID", -118326572);
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
$data = getPosts();
$f = fopen(dirname(__FILE__).'/data/posts.json', 'c');
fwrite($f, json_encode($data));
fclose($f);