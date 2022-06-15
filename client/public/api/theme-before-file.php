<?php

include("connect.php");

if (isset($_POST['thumb-dir'])) {
  $dir = ".{$_POST['thumb-dir']}";
  $data = array();
  $name = "";
  if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
      while (($file = readdir($dh)) !== false) {
        if ($file != "." && $file != ".." && $file != "{$_POST['current-img']}") {
          $data[] = $file;
        }
      }
      closedir($dh);
    }
  }
}

echo json_encode($data);