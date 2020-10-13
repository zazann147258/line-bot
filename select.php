<?php

$url = 'http://bot.kantit.com/select.php';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);   		   
$obj = json_decode($result);		   

echo $result;

?>
