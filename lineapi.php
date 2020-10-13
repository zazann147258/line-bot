<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
	$code = 405;
	$text = "Accept \"POST\" Method requests";
	header($protocol . ' ' . $code . ' ' . $text);
	exit();
}

?>
