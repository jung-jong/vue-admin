<?php

include("connect.php");

$sql = "SELECT * FROM TB_UPLOAD_FILE WHERE SEQ_ID = '{$_POST['SEQ_ID']}'";

$result = mysqli_query($conn, $sql);


$data = array();
while($row = mysqli_fetch_assoc($result)){
  $data[] = $row;
}

$id = "{$data[0]["FILE_DIR"]}";
$filename = "{$data[0]["FILE_NAME"]}";
$file_dir = "../user/{$id}/upload/{$filename}";

if (isset($filename)) {
  @unlink($file_dir);
  echo "delete success";
  $filename = "";
}

// echo empty($filename);
if (empty($filename)) {
  $sql ="DELETE FROM TB_UPLOAD_FILE WHERE SEQ_ID = {$_POST['SEQ_ID']}";
  $result = mysqli_query($conn, $sql);
  if ($result == false) {
    error_log(mysqli_error($conn));
    $data = array('DB'=>"error");
  } else {
    $data = array('DB'=>"success");
  }
  echo json_encode($data);
} else {
  echo "File not delete";
}

mysqli_close($conn);

?>