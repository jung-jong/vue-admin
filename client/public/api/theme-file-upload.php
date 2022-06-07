<?php

if (!is_dir("../contents/template/thumb")) {
    mkdir("../contents/template/thumb", 0777, true);
}

if (!is_dir("../contents/text/thumb")) {
  mkdir("../contents/text/thumb", 0777, true);
}

if (!is_dir("../contents/shape/thumb")) {
  mkdir("../contents/shape/thumb", 0777, true);
}

if (!is_dir("../contents/table/thumb")) {
  mkdir("../contents/table/thumb", 0777, true);
}

if (!is_dir("../contents/chart/thumb")) {
  mkdir("../contents/chart/thumb", 0777, true);
}

if (!is_dir("../contents/style/thumb")) {
  mkdir("../contents/style/thumb", 0777, true);
}

if (isset($_POST['thumbnail'])) {
  $data = "{$_POST['base64']}";
  $src = explode(',',$data);
  $result = base64_decode($src[1]);
  $saveDir = ".{$_POST['thumbnail']}";
  
  file_put_contents($saveDir, $result);
}

if (isset($_POST['contents'])) {
  $data = "{$_POST['base64']}";
  $src = explode(',',$data);
  $result = base64_decode($src[1]);
  $saveDir = ".{$_POST['contents']}";
  
  file_put_contents($saveDir, $result);
}
 
?>