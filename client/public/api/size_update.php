<?php

include("connect.php");

$sql = "UPDATE `TB_SIZE`
SET `PAGE_WIDTH` = {$_POST['PAGE_WIDTH']}, `PAGE_HEIGHT` = {$_POST['PAGE_HEIGHT']}, `SCALE_CD` = {$_POST['SCALE_CD']}
WHERE `SEQ_ID` = {$_POST['SEQ_ID']}";

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