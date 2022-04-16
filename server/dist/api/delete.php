<?php
include('connect.php');

// $_POST = json_decode(file_get_contents('php://input'), true);
// settype($_POST['id'], 'integer');
$sql ="DELETE FROM tb_project WHERE SEQ_ID = {$_POST['SEQ_ID']}";
  $result = mysqli_query($conn, $sql);
  if ($result == false) {
    error_log(mysqli_error($conn));
    $data = array('result'=>"error");
  } else {
    $data = array('result'=>"success");
  }
  echo json_encode($data);

mysqli_close($conn);
?>