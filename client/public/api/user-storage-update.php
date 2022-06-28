<?php
include("connect.php");
header("Content-Type:text/html;charset=utf-8");

if (isset($_GET['id'])) {
  $sql = "SELECT * FROM TB_MY_UPLOAD WHERE FILE_DIR = '{$_GET['id']}'";
  
  $result = mysqli_query($conn, $sql);

  $data = array();
  while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
  }

  $idx=0;
  $storage = 0;
  foreach($data as $row)
  {
    $id = $data[$idx]["FILE_DIR"];
    $file_name = $data[$idx]["FILE_NAME"];
    $file_dir = "../user/{$id}/upload/{$file_name}";
    $file_size = filesize($file_dir);
    $data[$idx]["FILE_SIZE"] = $file_size;
    $storage += $data[$idx]["FILE_SIZE"];

    $idx++;
  }

  echo json_encode($storage);
}

if (isset($_POST['STORAGE_USE'])) {
  $sql = "UPDATE `TB_USER_STATUS` 
  SET `STORAGE_USE` = {$_POST['STORAGE_USE']}, `U_DATE` = CURRENT_TIMESTAMP()
  WHERE `USER_ID` = '{$_POST['USER_ID']}'";
  
  
  $result = mysqli_query($conn, $sql);
  $use = array();
  if ($result == false) {
    error_log(mysqli_error($conn));
    $use = array('DB'=>"error");
  } else {
    $use = array('DB'=>"success");
  }

  echo json_encode($use);
}

mysqli_close($conn);
