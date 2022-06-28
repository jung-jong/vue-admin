<?php

include("connect.php");
include("axios.php");

if (isset($_POST['deleteTheme'])) {
  $sql = "DELETE FROM `TB_THEME` WHERE `SEQ_ID` = {$_POST['deleteTheme']}";
}

if (isset($_POST['THEME_ID'])) {
  $sql = "UPDATE `TB_CONTENTS`
  SET `D_DATE` = CURRENT_TIMESTAMP()
  WHERE `THEME_ID` = {$_POST['THEME_ID']}";
}

if (isset($_POST['deleteContents'])) {
  $sql = "DELETE FROM `TB_CONTENTS` WHERE `SEQ_ID` = {$_POST['deleteContents']}";

  $dir = ".{$_POST['contentsPath']}thumb/";
  $id = "{$_POST['deleteContents']}";
  $data = array();
  $name = "";
  if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
      while (($file = readdir($dh)) !== false) {
        if ($file != "." && $file != "..") {
          $file = (explode("_", $file));
          if ($file[0] == $id) {
            $data[] = $file;
          }
        }
      }
      closedir($dh);
    }
  }
  foreach ($data as $key => $data) {
    $i = 0;
    $i++;
    $data = array($dir . $id . "_" . $data[$i]);
    $data = $data[0];
    if (!file_exists($data)) {
      echo "썸네일 파일 삭제실패\n";
      return;
    } else {
      unlink($data);
    }
  }

  $dir = ".{$_POST['contentsPath']}";
  $id = "{$_POST['deleteContents']}";
  $data = array();
  $name = "";
  if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
      while (($file = readdir($dh)) !== false) {
        if ($file != "." && $file != ".." && $file != "thumb") {
          $file = (explode("_", $file));
          if ($file[0] == $id) {
            $data[] = $file;
          }
        }
      }
      closedir($dh);
    }
  }
  foreach ($data as $key => $data) {
    $i = 0;
    $i++;
    $data = array($id . "_" . $data[$i]);
    $data = $data[0];
    $data = $dir . $data;

    if (!file_exists($data)) {
      echo "컨텐츠 파일 삭제실패\n";
      return;
    } else {
      unlink($data);
    }
  }
}

post($conn, $sql);

echo json_encode($data);

mysqli_close($conn);
