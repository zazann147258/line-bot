<?php

$url = 'http://bot.kantit.com/select.php';
//$url = 'https://covid19.th-stat.com/api/open/today';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);   		   
$obj = json_decode($result);		   

echo $result;

?>
