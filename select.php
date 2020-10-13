<?php

$url = 'http://bot.kantit.com/select.php';  

$result = file_get_contents($url);

$result_json = json_decode($result, true);

foreach($result_json->id as $data)
{
    echo $data.'<br>';
}

?>
