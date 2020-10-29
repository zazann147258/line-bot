<?php

$channelAccessToken = 'qQJOynpqEHSDLcD52g15om6bZjx0HYWEjvRvHnaFkCWwL+hTD1p+VieN1fx8V4IZg9KdB90QcHuea/80mItEpG9QskU4H5czwjCMjif9Ck6cRlzP4jHPOQXo4RQ8wY+MXH1Y1uqUgMBh4kwCFP+SOAdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น

$request = file_get_contents('php://input');   // Get request content

$request_json = json_decode($request, true);   // Decode JSON request

foreach ($request_json['events'] as $event)
{
 if ($event['type'] == 'message') 
 {
  if($event['message']['type'] == 'text')
  {
   $text = $event['message']['text'];
   
   $reply_message = 'ฉันได้รับข้อความ '. $text.' ของคุณแล้ว!';   
   
   $reply_message = 'Jakkarin';  
   
   $reply_message = mySQL_selectAll('http://s61160172.kantit.com/json_select.php');
   
  } else {
   $reply_message = 'ฉันได้รับ '.$event['message']['type'].' ของคุณแล้ว!';
  }
 } else {
  $reply_message = 'ฉันได้รับ Event '.$event['type'].' ของคุณแล้ว!';
 }
 
 // reply message
 $post_header = array('Content-Type: application/json', 'Authorization: Bearer ' . $channelAccessToken);
 $data = ['replyToken' => $event['replyToken'], 'messages' => [['type' => 'text', 'text' => $reply_message]]];
 $post_body = json_encode($data);
 $send_result = replyMessage('https://api.line.me/v2/bot/message/reply', $post_header, $post_body);
 //$send_result = send_reply_message('https://api.line.me/v2/bot/message/reply', $post_header, $post_body);
}

function replyMessage($url, $post_header, $post_body)
{
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => $post_header,
                'content' => $post_body,
            ],
        ]);
 
 $result = file_get_contents($url, false, $context);

 return $result;
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

function mySQL_selectAll($url)
{
 $result = file_get_contents($url);
 
 $result_json = json_decode($result, true); //var_dump($result_json);
 
 $data = "ผลลัพธ์:\r\n";
  
 foreach($result_json as $values) {
  $data .= $values["stuid"] . " " . $values["full_name"] . " " .  "\r\n";
 }
 
 return $data;
}

?>
