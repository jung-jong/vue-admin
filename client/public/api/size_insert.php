<?php

include("connect.php");

$sql = "INSERT INTO `TB_SIZE` (`SIZE_CATEGORY_ID`, `SIZE_NAME`, `ORDER`, `A_ID`, `U_ID`)
 VALUES ({$_POST['SIZE_CATEGORY_ID']}, '{$_POST['SIZE_NAME']}', {$_POST['ORDER']}, 0, 0)";

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