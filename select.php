<?php

$url = 'http://bot.kantit.com/select.php';  

$result = file_get_contents($url);

$result_json = json_decode($result, true);

//var_dump($result_json);

$data = array();

foreach($result_json as $values) {
  
  //var_dump($values); echo "<br>";
  
  foreach($values as $key => $value) {
    var_dump($value['id']); 
    //echo $key . " => " . $value . "<br>";
    //array_push($data, array("fullname"=>$value['msg_from']));
  }
  //echo "<br>";  
}

//var_dump($data);

?>
