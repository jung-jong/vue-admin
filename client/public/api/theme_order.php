<?php

include("connect.php");

if (isset($_POST['SEQ_ID'])) {
  $sql = "UPDATE `TB_THEME`
  SET `ORDER` = {$_POST['ORDER']}
  WHERE `SEQ_ID` = {$_POST['SEQ_ID']}";
}

if (isset($_POST['NEXT'])) {
  $sql = "UPDATE `TB_THEME`
  SET `ORDER` = {$_POST['ORDER']}
  WHERE `SEQ_ID` = {$_POST['NEXT']}";
}

if (isset($_POST['PREV'])) {
  $sql = "UPDATE `TB_THEME`
  SET `ORDER` = {$_POST['ORDER']}
  WHERE `SEQ_ID` = {$_POST['PREV']}";
}

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