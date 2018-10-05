<?php

$files = scandir(__DIR__, SCANDIR_SORT_ASCENDING);
foreach($files as $f){
	if($f && !strpos(' '.$f, '!') && !is_dir(__DIR__ . '/' . $f) && $f != "index.php"){
		include(__DIR__.'/'.$f);
	} 
}