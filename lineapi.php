<?php

$ACCESS_TOKEN = 'PZ6qlbYABvcIg+sly4KFcjs8rAVOW1+EEEDBgcOn86a9MwA+MNHV8//FPERaqcVuWnKEs4U+6oe0jLA++fQlGKdK9/SCRKlZ0x4otRbscQZBRbe5VDkXvu32iZAA+dpXEwrb47Ncr9kuH1vSp+t3LwdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น

$request = file_get_contents('php://input');   // Get request content

$request_array = json_decode($request, true);   // Decode JSON request

foreach ($request_array['events'] as $event)
{
	if ( $event['type'] == 'message' ) 
	{
		if( $event['message']['type'] == 'text' )
		{
	   $text = $event['message']['text'];
	   $reply_message = 'ระบบได้รับ '. $text.' ของคุณแล้ว!';   
   }
   else
    $reply_message = 'ระบบได้รับ '.$event['message']['type'].' ของคุณแล้ว!';
  
  }
  else
   $reply_message = 'ระบบได้รับ Event '.$event['type'].' ของคุณแล้ว!';
 
  if( strlen($reply_message) > 0 )
  {	  
  
   $send_result = send_reply_message($ACCESS_TOKEN, $event['replyToken'], $reply_message);
	  
   echo "Result: ".$send_result."\r\n";
	  
  }
	
 }

function send_reply_message($channelAccessToken, $replyToken, $reply_message)
{
		   $data = [
    'replyToken' => $replyToken,
    'messages' => [['type' => 'text', 'text' => $reply_message]]
   ];
   $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
	
	
	$post_header = array('Content-Type: application/json', 'Authorization: Bearer ' . $channelAccessToken);
 $ch = curl_init('https://api.line.me/v2/bot/message/reply');
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
