<?php
	$page_URL = (@$_SERVER['HTTPS'] == 'on') ? "https://" : "http://";
 	$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  	$uri_segments = explode('/', $uri_path);
?>