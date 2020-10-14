<?php

$channelAccessToken = 'PZ6qlbYABvcIg+sly4KFcjs8rAVOW1+EEEDBgcOn86a9MwA+MNHV8//FPERaqcVuWnKEs4U+6oe0jLA++fQlGKdK9/SCRKlZ0x4otRbscQZBRbe5VDkXvu32iZAA+dpXEwrb47Ncr9kuH1vSp+t3LwdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น

$request = file_get_contents('php://input');   // Get request content

$request_json = json_decode($request, true);   // Decode JSON request

foreach ($request_json['events'] as $event)
{
	if ($event['type'] == 'message') 
	{
		if($event['message']['type'] == 'text')
		{
			$text = $event['message']['text'];
			
			$reply_message = 'ระบบได้รับข้อความ '. $text.' ของคุณแล้ว!';
			
			if($text == "@บอท ขอรายชื่อนิสิตทั้งหมด"){
				$reply_message = mySQL_select('http://bot.kantit.com/select_users.php');
			}
			
		} else {
			$reply_message = 'ระบบได้รับ '.$event['message']['type'].' ของคุณแล้ว!';
		}
	} else {
		$reply_message = 'ระบบได้รับ Event '.$event['type'].' ของคุณแล้ว!';
	}
		
	$post_header = array('Content-Type: application/json', 'Authorization: Bearer ' . $channelAccessToken);
	
	$data = ['replyToken' => $event['replyToken'], 'messages' => [['type' => 'text', 'text' => $reply_message]]];
	
	$post_body = json_encode($data);
	
	//mySQL('http://bot.kantit.com/insert_json.php');
	
	//$mysql_result =  mySQL('http://bot.kantit.com/insert_json.php');
	
	//if($callback){
	
	// reply message	
	$send_result = replyMessage('https://api.line.me/v2/bot/message/reply', $post_header, $post_body);
	//$send_result = send_reply_message('https://api.line.me/v2/bot/message/reply', $post_header, $post_body);
	
	//}
}
function mySQL_select($url)
{
	$result = file_get_contents($url);
	
	$result_json = json_decode($result, true); //var_dump($result_json);
	
	$data = array();
	
	foreach($result_json as $values) {
		
		$data = $values["user_stuid"];
  
  //var_dump($values); echo "<br>";
  
  //echo $values["user_stuid"] . " " . $values["user_firstname"] . " " . $values["user_lastname"] . "<br>";
	}
	
	return $data;
}

function mySQL($url)
{
	$post_header = array('Content-Type: application/json');
	$data = ['replyToken' => 'xxxx', 'messages' => 'xxxxxx'];
	$post_body = json_encode($data);
	 $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => $post_header,
                'content' => $post_body,
            ],
        ]);
	
	//$result = file_get_contents($url, false, $context);
	
	$result = file_get_contents($url, false, null);
	
	return $result;
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

?>
