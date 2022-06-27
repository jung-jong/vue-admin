<?php

include("connect.php");

$sql = "SELECT * FROM TB_MY_UPLOAD WHERE SEQ_ID = '{$_POST['SEQ_ID']}'";

$result = mysqli_query($conn, $sql);


$data = array();
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

$id = "{$data[0]["FILE_DIR"]}";
$filename = "{$data[0]["FILE_NAME"]}";
$file_dir = "../user/{$id}/upload/{$filename}";

if (!file_exists($file_dir)) {
  echo "파일 삭제실패\n";
  return;
} else {
  unlink($file_dir);
  $sql = "DELETE FROM TB_MY_UPLOAD WHERE SEQ_ID = {$_POST['SEQ_ID']}";
  $result = mysqli_query($conn, $sql);
  if ($result == false) {
    error_log(mysqli_error($conn));
    $data = array('DB' => "error");
  } else {
    $data = array('DB' => "success");
  }
}

echo json_encode($data);

mysqli_close($conn);
