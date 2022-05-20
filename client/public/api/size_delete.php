<?php

include("connect.php");

$sql = "DELETE FROM `TB_SIZE` WHERE `SIZE_CATEGORY_ID` = {$_POST['SIZE_CATEGORY_ID']}";

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