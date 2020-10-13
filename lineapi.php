<?php

$LINE_API = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'PZ6qlbYABvcIg+sly4KFcjs8rAVOW1+EEEDBgcOn86a9MwA+MNHV8//FPERaqcVuWnKEs4U+6oe0jLA++fQlGKdK9/SCRKlZ0x4otRbscQZBRbe5VDkXvu32iZAA+dpXEwrb47Ncr9kuH1vSp+t3LwdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

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
	$reply_token = $event['replyToken'];
	$reply_message = '';
	
	switch ($event['type']) {
		case 'message':
			$message = $event['message'];
			switch ($message['type']) {
				case 'text':
					$reply_message = 'hello';
			
					break;
				default: error_log('Unsupported message type: ' . $message['type']);
					break;
			}
			break;
		default:
			error_log('Unsupported event type: ' . $event['type']);
			break;
	}
	
	if(strlen($reply_message) > 0 ) {
		$data = ['replyToken' => $reply_token, 'messages' => [['type' => 'text', 'text' => $reply_message]]];
		$post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
		//$send_result = send_reply_message($API_URL, $POST_HEADER, $post_body);
		$send_result = replyMessage($post_body);
	}
	
}

function replyMessage($post_body)
{	
   $response = file_get_contents('https://api.line.me/v2/bot/message/reply', false, $post_body);
}

?>
