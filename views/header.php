<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="%ASSETS%/style.css?<?php echo rand();?>" />
	<meta name="theme-color" content="#000000">
	<meta name="msapplication-navbutton-color" content="#000000">
	<meta name="apple-mobile-web-app-status-bar-style" content="#000000">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="HandheldFriendly" content="True">
	<meta charset="UTF-8" >
	<title><?php echo isset($title) ? $title : $site_title;?></title>
</head>
<body>
<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark navbar-expand-md">
	<div class="container">
		<a class="navbar-brand" href="/">
			<span><?php echo $site_title;?></span>
		</a>
		<div class="navbar-collapse collapse show">
			<div class="navbar-nav ml-auto">
				<a href="#fb-widget" class="nav-link fb-inline">Widget for site</a>
				<a href="#" class="nav-link" target="_blank">Chrome Extension</a>
				<a class="fb-inline nav-link" href="#fb-auth">
					Register / Log in
				</a>
			</div>
		</div>
	</div>
</nav>