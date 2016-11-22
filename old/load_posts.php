<?php
define("WALL_ID", -118326572);
function getPosts(){
	$url = 'https://api.vk.com/method/wall.get';
	$params = array(
		'owner_id' => WALL_ID,
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

function parseLinks($str){
	$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	$urls = array();
	$urlsToReplace = array();
	if(preg_match_all($reg_exUrl, $str, $urls)) {
		$numOfMatches = count($urls[0]);
		$numOfUrlsToReplace = 0;
		for($i=0; $i<$numOfMatches; $i++) {
			$alreadyAdded = false;
			$numOfUrlsToReplace = count($urlsToReplace);
			for($j=0; $j<$numOfUrlsToReplace; $j++) {
				if($urlsToReplace[$j] == $urls[0][$i]) {
					$alreadyAdded = true;
				}
			}
			if(!$alreadyAdded) {
				array_push($urlsToReplace, $urls[0][$i]);
			}
		}
		$numOfUrlsToReplace = count($urlsToReplace);
		for($i=0; $i<$numOfUrlsToReplace; $i++) {
			$str = str_replace($urlsToReplace[$i], "<a href=\"".$urlsToReplace[$i]."\">".$urlsToReplace[$i]."</a> ", $str);
		}
		return $str;
	} else {
		return $str;
	}
}

function genPost($p){
	$html = "";
	$html .= "<span class=\"fl_r\">".date("d.m.Y, G:i", $p['date'])."</span>";
	$html .= "\r\n";
	if(strlen($p['text'])){
		$text = $p['text'];
		$text = parseLinks($text);
		$text = nl2br($text);
		$html .= "<p>".$text."</p>";
	}
	if(is_array($p['attachments'])){
		$html .= genAttachment($p['attachments']);
	}
	$html .="<a class=\"goto_source\" href=\"https://vk.com/wall". $p['from_id'] ."_". $p['id'] . "\">Відкрити джерело</a>";
	return $html;
}
function genAttachment($arr){
	$data = "";
	$data .= '<div class="card_wrapper">';
	foreach($arr as $a){
		switch($a['type']){
			case "link":
				$data .= '<a href="' . $a['link']['url'] . '" target="_blank"><div class="card cw3">';
				if($a['link']['photo']){
					$data .= '<div class="img" style="background-image:url(' . $a['link']['photo']['photo_604'] . ')"></div>';
				}
				$data .= '<div class="content">';
					if($a['link']['title']){
						$data .= '<span class="link">' . $a['link']['title'] . '</span>';
					}
					if($a['link']['description']){
						$data .= $a['link']['description'];
					}
				$data .= '</div>';
				$data .= '</div></a>';
				break;

			case "album":
				$data .= '<a href="https://vk.com/album' . $a['album']['thumb']['owner_id'] . "_" . $a['album']['thumb']['album_id'] . '" target="_blank"><div class="card cw3">';
				if($a['album']['thumb']){
					$data .= '<div class="img" style="background-image:url(' . $a['album']['thumb']['photo_1280'] . ')"></div>';
				}
				$data .= '<div class="content">';
					if($a['album']['title']){
						$data .= '<span class="link">' . $a['album']['title'] . '</span>';
					}
					if($a['album']['description']){
						$data .= $a['album']['description'];
					}
				$data .= '</div>';
				$data .= '</div></a>';
				break;

			case "photo":
				$data .= '<a href="' . $a['photo']['photo_1280'] . '"target="_blank"><div class="card cw3 ch3">';
				$data .= '<div class="img" style="background-image:url(' . $a['photo']['photo_1280'] . ')"></div>';
				$data .= '</div></a>';
				break;

			case "video":
				$data .= '<a href="https://vk.com/video' . $a['video']['owner_id'] . "_" . $a['video']['id'] . '" target="_blank"><div class="card cw3">';
				if($a['video']['photo_800']){
					$data .= '<div class="img" style="background-image:url(' . $a['video']['photo_800'] . ')"></div>';
				}
				$data .= '<div class="content">';
					if($a['video']['title']){
						$data .= '<span class="link">' . $a['video']['title'] . '</span>';
					}
					if($a['video']['description']){
						$data .= $a['video']['description'];
					}
				$data .= '</div>';
				$data .= '</div></a>';
				break;
		}
	}
	$data .= '</div>';
	return $data;
}
function genFeed($p){
	$arr = [];	
	$arr["link"] = "/post/" . $p['id'];


	for($i=0;$i<count($p['attachments'][$i]);$i++){
		if(is_array($p['attachments'][$i]) && is_array($p['attachments'][$i]['album']['title'])){
			$title = $p['attachments'][$i]['album']['title'];
			$title = nl2br($title);
			$arr["title"] = $title;
		}else if(is_array($p['attachments'][$i]) && is_array($p['attachments'][$i]['link']['title'])){
			$title = $p['attachments'][$i]['link']['title'];
			$title = nl2br($title);
			$arr["title"] = $title;
			$arr["title"] = $title;
		}else if(is_array($p['attachments'][$i]) && is_array($p['attachments'][$i]['video']['title'])){
			$title = $p['attachments'][$i]['video']['title'];
			$title = nl2br($title);
			$arr["title"] = $title;
			$arr["title"] = $title;
		}
	}

	for($i=0;$i<count($p['attachments'][$i]);$i++){
		if(strlen($p['text'])){
			$text = $p['text'];
			$text = nl2br($text);
			if(strpos($text, ' ') && strlen($text)>260){
				$text = substr($text, 0, strpos($text, ' ', 260)) . "...";
			}
			$arr["text"] = $text;
		}else if(is_array($p['attachments'][$i]) && is_array($p['attachments'][$i]['album']['description'])){
			$text = $p['attachments'][$i]['album']['description'];
			$text = nl2br($text);
			if(strpos($text, ' ') && strlen($text)>260){
				$text = substr($text, 0, strpos($text, ' ', 260)) . "...";
			}
			$arr["text"] = $text;
		}else if(is_array($p['attachments'][$i]) && is_array($p['attachments'][$i]['video']['description'])){
			$text = $p['attachments'][$i]['video']['description'];
			$text = nl2br($text);
			if(strpos($text, ' ') && strlen($text)>260){
				$text = substr($text, 0, strpos($text, ' ', 260)) . "...";
			}
			$arr["text"] = $text;
		}else if(is_array($p['attachments'][$i]) && is_array($p['attachments'][$i]['link']['description'])){
			$text = $p['attachments'][$i]['album']['description'];
			$text = nl2br($text);
			if(strpos($text, ' ') && strlen($text)>260){
				$text = substr($text, 0, strpos($text, ' ', 260)) . "...";
			}
			$arr["text"] = $text;
		}
	}
	for($i=0;$i<count($p['attachments']);$i++){
		if(is_array($p['attachments'][$i]) && $p['attachments'][$i]['photo']){
			$arr["image"] = $p['attachments'][$i]['photo']['photo_1280'];
	
		}else if(is_array($p['attachments'][$i]) && count($p['attachments'][$i]['link'])){
			$arr["image"] = $p['attachments'][$i]['link']['photo']['photo_604'];	
		
		}else if(is_array($p['attachments'][$i]) && count($p['attachments'][$i]['album'])){
			$arr["image"] = $p['attachments'][$i]['album']['thumb']['photo_1280'];

		}else if(is_array($p['attachments'][$i]) && count($p['attachments'][$i]['video'])){
			$arr["image"] = $p['attachments'][$i]['video']['photo_800'];
	
		}
	}
	return count($arr)>1?$arr:false;
}
$posts = getPosts();
$feed = [];
foreach($posts as $post){
	$data = genPost($post);
	$f = genFeed($post);
	if($f){
		$feed[] = $f;
	}
	$cache_url = dirname(__FILE__).'/post/'.$post['id'].'.html';
	if(!file_exists($cache_url) || (time()-filemtime($cache_url)>15*60  &&  time()-filemtime($cache_url)<24*60*60)){
		$f = fopen($cache_url, 'c');
		fwrite($f, $data);
		fclose($f);
	}
}

$f = fopen(dirname(__FILE__).'/feed.json', 'c');
fwrite($f, json_encode($feed));
fclose($f);