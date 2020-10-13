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

//foreach ($request_json['events'] as $event)
//{
	//$reply_token = $event['replyToken'];
	//$reply_message = '';
	
	//switch ($event['type']) {
	//	case 'message':
	//		$message = $event['message'];
	//		switch ($message['type']) {
	//			case 'text':
					$reply_message = 'hello';
	//		
	//				break;
	//			default: error_log('Unsupported message type: ' . $message['type']);
	//				break;
	//		}
	//		break;
	//	default:
	//		error_log('Unsupported event type: ' . $event['type']);
	//		break;
	//}
	
	//if(strlen($reply_message) > 0 ) {
//		$data = ['replyToken' => $event['replyToken'], 'messages' => [['type' => 'text', 'text' => $reply_message]]];
		      //['replyToken' => $event['replyToken'], 'messages' => [['type' => 'text', 'text' => $message['text']]]]
		
//		$post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
//		$send_result = send_reply_message($LINE_API, $POST_HEADER, $post_body);
		
	//}
	
	//$send_result = replyMessage(['replyToken' => $event['replyToken'],'messages' => [['type' => 'text', 'text' => $message['text']]]);
//}



if ( sizeof($request_json['events']) > 0 )
{

 foreach ($request_json['events'] as $event)
 {
  $reply_message = '';
  $reply_token = $event['replyToken'];

  if ( $event['type'] == 'message' ) 
  {
   
   if( $event['message']['type'] == 'text' )
   {
	   $text = $event['message']['text'];
	   $reply_message = '('.$text.') ได้รับข้อความเรียบร้อย!!';   
   }
   else
    $reply_message = 'ระบบได้รับ '.ucfirst($event['message']['type']).' ของคุณแล้ว';
  
  }
  else
   $reply_message = 'ระบบได้รับ Event '.ucfirst($event['type']).' ของคุณแล้ว';
 
  if( strlen($reply_message) > 0 )
  {
   //$reply_message = iconv("tis-620","utf-8",$reply_message);
   $data = [
    'replyToken' => $reply_token,
    'messages' => [['type' => 'text', 'text' => $reply_message]]
   ];
   $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

   $send_result = send_reply_message($LINE_API, $POST_HEADER, $post_body);
   echo "Result: ".$send_result."\r\n";
  }
 }
}

function send_reply_message($url, $post_header, $post_body)
{
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 $result = curl_exec($ch);
 curl_close($ch);

 return $result;
}



				     
?>
