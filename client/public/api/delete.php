<?php
include('connect.php');

// $_POST = json_decode(file_get_contents('php://input'), true);
// settype($_POST['id'], 'integer');
$sql ="DELETE FROM tb_project WHERE SEQ_ID = {$_POST['id']}";
  $result = mysqli_query($conn, $sql);
  if ($result == false) {
    echo "삭제 실패";
    error_log(mysqli_error($conn));
    $data = array('result'=>"error");
  } else {
    echo "삭제 성공";
    $data = array('result'=>"success");
  }
  echo json_encode($data);

mysqli_close($conn);
?>