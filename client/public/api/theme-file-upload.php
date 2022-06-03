<?php

if (isset($_POST['thumbnail'])) {
  $data = "{$_POST['base64']}";
  $src = explode(',',$data);
  $result = base64_decode($src[1]);
  $saveDir = ".{$_POST['thumbnail']}";//로컬 + .
  
  file_put_contents($saveDir, $result);
}

if (isset($_POST['contents'])) {
  $data = "{$_POST['base64']}";
  $src = explode(',',$data);
  $result = base64_decode($src[1]);
  $saveDir = ".{$_POST['contents']}";//로컬 + .
  
  file_put_contents($saveDir, $result);
}
 
?>