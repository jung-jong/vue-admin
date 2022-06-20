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

if (isset($_POST['contentsDir'])) {
  $dir = ".{$_POST['contentsDir']}";
  $data = array();
  $name = "";
  if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
      while (($file = readdir($dh)) !== false) {
        if (
          $file != "." && $file != ".." && $file != "{$_POST['currentContents']}"
          && $file != "thumb" && preg_match("/{$_POST['SEQ_ID']}_/i", $file)
        ) {
          $data[] = $file;
        }
      }
      closedir($dh);
    }
  }
}

if (isset($_POST['deleteOldThumb'])) {
  $file = $_POST['deleteOldThumb'];
  if (!file_exists($file)) {
    echo "파일삭제 실패";
    return;
  }
  if (isset($file)) {
    @unlink($file);
    echo "success";
    return;
  }
}

if (isset($_POST['deleteOldContents'])) {
  $file = $_POST['deleteOldContents'];
  if (!file_exists($file)) {
    echo "파일삭제 실패";
    return;
  }
  if (isset($file)) {
    @unlink($file);
    echo "success";
    return;
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

if (isset($_POST['changeContents'])) {
  include("connect.php");

  $sql = "UPDATE TB_CONTENTS
  SET `CONTENTS_PATH` = '{$_POST['changeContents']}', `U_DATE` = CURRENT_TIMESTAMP()
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