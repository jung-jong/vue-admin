<?php

include("connect.php");

if (isset($_POST['deleteTheme'])) {
  $sql = "DELETE FROM `TB_THEME` WHERE `SEQ_ID` = {$_POST['deleteTheme']}";
}

if (isset($_POST['deleteContents'])) {
  $sql = "DELETE FROM `TB_CONTENTS` WHERE `SEQ_ID` = {$_POST['deleteContents']}";

  if (!file_exists(".{$_POST['thumbPath']}")) {
    echo "썸네일 이미지 삭제실패\n";
    return;
  } else {
    unlink(".{$_POST['thumbPath']}");
  }

  $dir = ".{$_POST['contentsPath']}";
  $id = "{$_POST['deleteContents']}";
  $data = array();
  $name = "";
  if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
      while (($file = readdir($dh)) !== false) {
        if ($file != "." && $file != ".." && $file != "thumb") {
          $data[] = $file;
        }
      }
      closedir($dh);
    }
  }
  foreach ($data as $data) {
    $name = strstr($data, $id);
    $data = array($name);
  }
  $name = $dir . $data[0];
  if (!file_exists($name)) {
    echo "컨텐츠 파일 삭제실패\n";
    return;
  } else {
    unlink($name);
  }
}

$result = mysqli_query($conn, $sql);
if ($result == false) {
  error_log(mysqli_error($conn));
  $data = array('DB' => "error");
} else {
  $data = array('DB' => "success");
}

echo json_encode($data);

mysqli_close($conn);