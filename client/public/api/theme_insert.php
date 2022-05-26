<?php

include("connect.php");

$sql = "INSERT INTO `TB_THEME` (`CONTENTS_CATEGORY_ID`, `THEME_NAME`, `ORDER`, `A_ID`, `U_ID`)
 VALUES ({$_POST['CONTENTS_CATEGORY_ID']}, '{$_POST['THEME_NAME']}', {$_POST['ORDER']}, '0', '0');";

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