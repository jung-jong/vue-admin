<?php

include("connect.php");

if (isset($_POST['SIZE_CATEGORY_ID'])) {
  $sql = "DELETE FROM `TB_SIZE` WHERE `SIZE_CATEGORY_ID` = {$_POST['SIZE_CATEGORY_ID']}";
}

if (isset($_POST['SIZE'])) {
  $sql = "DELETE FROM `TB_SIZE` WHERE `SEQ_ID` = {$_POST['SIZE']}";
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