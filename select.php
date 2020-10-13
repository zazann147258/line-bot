<?php

$url = 'https://bot.kantit.com/select.php';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);   		   
//$obj = json_decode($result);		   

echo $result;

?>
