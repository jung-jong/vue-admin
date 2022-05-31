<?php

include("connect.php");


$sql = "INSERT INTO `TB_CONTENTS` (`CONTENTS_NAME`, `THEME_ID`, `KEYWORD`, `THUMB_PATH`, `CONTENTS_PATH`, `USE_TYPE`, `SIZE_CATEGORY_ID`, `SIZE_INFO_ID`, `PUBLIC_FLAG`, `A_ID`, `U_ID`)
VALUE ('{$_POST['CONTENTS_NAME']}', {$_POST['THEME_ID']}, '{$_POST['KEYWORD']}', '{$_POST['THUMB_PATH']}', '{$_POST['CONTENTS_PATH']}', {$_POST['USE_TYPE']},
 {$_POST['SIZE_CATEGORY_ID']}, {$_POST['SIZE_INFO_ID']}, {$_POST['PUBLIC_FLAG']}, {$_POST['A_ID']}, {$_POST['U_ID']})";

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