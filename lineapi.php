<?php

$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {	
	$code = 405;
	$text = 'Accept "POST" Method requests';
	header($protocol . ' ' . $code . ' ' . $text);
	exit();
}

if($_SERVER['CONTENT_TYPE'] != 'application/json'){
	$code = 444;
	$text = 'Accept "JSON" request';
	header($protocol . ' ' . $code . ' ' . $text);
        exit();
}

$request = file_get_contents('php://input');

if (strlen($request) === 0) {
	$code = 400;
	$text = 'Missing "JSON" request body';
	header($protocol . ' ' . $code . ' ' . $text);
	exit();
}

?>
