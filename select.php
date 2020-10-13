<?php

$url = 'http://bot.kantit.com/select.php';  

$result = file_get_contents($url);

$result_json = json_decode($result, true);

//var_dump($result_json);

foreach($result_json as $key => $values) {
  //var_dump($values); echo "<br>";
  foreach($values as $key => $value) {
      var_dump($value); 
  }
  echo "<br>";
  //echo $key . " => " . $value . "<br>";
}

?>
