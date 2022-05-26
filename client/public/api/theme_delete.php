<?php

include("connect.php");

$sql = "DELETE FROM `TB_THEME` WHERE `SEQ_ID` = {$_POST['SEQ_ID']}";

$result = mysqli_query($conn, $sql);
if ($result == false) {
  error_log(mysqli_error($conn));
  $data = array('DB'=>"error");
} else {
  $data = array('DB'=>"success");
}

echo json_encode($data);

mysqli_close($conn);

?>