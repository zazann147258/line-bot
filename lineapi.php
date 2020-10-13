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

$request = file_get_contents('php://input'); // Input JSON request

if (strlen($request) === 0) {
	$code = 400;
	$text = 'Missing "JSON" request body';
	header($protocol . ' ' . $code . ' ' . $text);
	exit();
}

$request_json = json_decode($request, true);   // Decode JSON request

foreach ($request_json['events'] as $event)
{
	//$reply_message = '';
	//$reply_token = $event['replyToken'];
	
	switch ($event['type']) {
		case 'message':
			$message = $event['message'];
			switch ($message['type']) {
				case 'text':
					break;
				default: error_log('Unsupported message type: ' . $message['type']);
					break;
			}
			break;
		default:
			error_log('Unsupported event type: ' . $event['type']);
			break;
	}
}

?>
