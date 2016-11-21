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
<?php
if(isset($_GET['_']) && $_GET['_']){
	$postId = $_GET['_'];
}
$url = dirname(__FILE__) . "/post/" . $postId . ".html";
if(file_exists($url)){
	ob_start();
		include($url);
		$innerHTML = ob_get_contents();
	ob_end_clean();
	echo $innerHTML;
}else{
?>

<h1>Помилка 404</h1>
<p>
	Стаття не знайдена, але ви тримайтесь там, всього Вам доброго, гарного настрою і здоров'я.
</p>
<?php
}
?>
</div>

<a class="scrolltop" style="bottom:-48px;" href="#top"><img src="/assets/images/up-arrow.png"></a>
</body>
<script src="/assets/js/script.js"></script>
</html>