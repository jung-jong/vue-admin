<?php

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

if (isset($_POST['deleteBeforeThumb'])) {
  $file = $_POST['deleteBeforeThumb'];
  if (!file_exists($file)) {
    echo "파일삭제 실패";
    return;
  }
  if (isset($file)) {
    @unlink($file);
    echo "success";
    return;
    // $sql = "UPDATE TB_CONTENTS
    // SET `THUMB_PATH` = '{$_POST['THUMB_PATH']}', `U_DATE` = CURRENT_TIMESTAMP()
    // WHERE `SEQ_ID` = {$_POST['SEQ_ID']}";
  }
}

if (isset($_POST['changeThumb'])) {
  include("connect.php");

  $sql = "UPDATE TB_CONTENTS
  SET `THUMB_PATH` = '{$_POST['changeThumb']}', `U_DATE` = CURRENT_TIMESTAMP()
  WHERE `SEQ_ID` = {$_POST['SEQ_ID']}";

  $result = mysqli_query($conn, $sql);
  if ($result == false) {
    error_log(mysqli_error($conn));
    $data = array('DB' => "error");
  } else {
    $data = array('DB' => "success");
  }

  mysqli_close($conn);
}

echo json_encode($data);
