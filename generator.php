<?php

function gen($len){
  $x = '';

  $str = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

  for($i=0; $i<$len; $i++){
    $x .= substr($str, mt_rand(0, strlen($str)-1), 1);
  }

  return $x;
}

$arr = array();

for ($i =0; $i < 1000000; $i++){
  $arr[gen(10)] = gen(20);
}

ksort($arr);

$file=fopen("data","w");
foreach($arr as $key => $value){
  fwrite($file, $key."\t".$value."\n");
}
fclose($file);

print_r("<pre>");
print_r($arr);
print_r("</pre>");
