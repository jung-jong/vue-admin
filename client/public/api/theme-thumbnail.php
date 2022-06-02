<?php

$data = "{$_POST['base64']}";
$src = explode(',',$data);
$result = base64_decode($src[1]);
echo $src;
$saveDir = "{$_POST['file']}.png";

file_put_contents($saveDir, $result);
 
?>