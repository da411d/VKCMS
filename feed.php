<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>

<head>
	<title>Головна</title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="/assets/css/style.css" type="text/css" />
	<link rel="stylesheet" href="/assets/fonts/lato.css" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="HandheldFriendly" content="True">
	<meta name="yandex-verification" content="56bcb3665e77345e" />
</head>
<body>
  <div class="header" id="top">
	<div class="header_container">
		<span class="h1" ondblclick="Flashlight.toggle()">Фізико-Технічний Ліцей</span>
		<span class="txt">Per aspera ad astra</span>
		<nav id="nav">
			<a href="/">Головна</a>
			<a href="/feed">Новини</a>
			<a href="/gallery">Галерея</a>
		</nav>
		<div class="bg_wrapper">
			<div class="bg_img" id="bg_img"></div>
		</div>
	</div>
</div>

<div class="main">
<h1>Новини</h1>
<?php
function genCard($cards, $cols=3){
	$echoer = '<div class="card_wrapper" data-masonry=\'{"itemSelector": ".card","percentPosition": true,"transitionDuration": "0s","stamp": "h2"}\'>';
	foreach($cards as $c){
		$cls = isset($c['cols'])?$c['cols']:$cols;
		$id = isset($c['id'])?'id="'.$c['id'].'"':false;
		$target = isset($c['target'])?'target="'.$c['target'].'"':false;

		$placeholder = isset($c['image'])?$c['image']:false;
		$link = isset($c['link'])?$c['link']:false;
		$title = isset($c['title'])?$c['title']:false;
		$text = isset($c['text'])?$c['text']:false;
		
		if($link){
			$echoer .= '<a href="' . $link . '"' . $target . '>';
		}
		$echoer .= '<div class="card cw' . $cls . '"' . $id . '>';
			if($placeholder){
				$echoer .= '<div class="img" style="background-image:url(' . $placeholder . ')"></div>';
			}
			if($title || $text){
				$echoer .= '<div class="content">';
					if($title){
						$echoer .= '<span class="link">' . $title . '</span>';
					}
					if($text){
						$echoer .= $text;
					}
				$echoer .= '</div>';
			}
			$echoer .= '</div>';
		if($link){
			$echoer .= '</a>';
		}
	}
	$echoer .= '</div>';
	return $echoer;
}

	$file = file_get_contents("feed.json");
	$arr = json_decode($file, 1);
	echo genCard($arr)
?>
</div>

<a class="scrolltop" style="bottom:-48px;" href="#top"><img src="/assets/images/up-arrow.png"></a>
</body>
<script src="/assets/js/script.js"></script>
</html>