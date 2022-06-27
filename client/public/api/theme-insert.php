<?php

include("connect.php");
include("axios.php");

if (isset($_POST['CONTENTS_CATEGORY_ID'])) {
  $sql = "INSERT INTO `TB_THEME` (`CONTENTS_CATEGORY_ID`, `THEME_NAME`, `ORDER`, `A_ID`, `U_ID`)
 VALUES ({$_POST['CONTENTS_CATEGORY_ID']}, '{$_POST['THEME_NAME']}', {$_POST['ORDER']}, '0', '0');";
}

if (isset($_POST['CONTENTS_NAME'])) {
  $sql = "INSERT INTO `TB_CONTENTS` (`CONTENTS_NAME`, `THEME_ID`, `KEYWORD`, `THUMB_PATH`,
 `CONTENTS_PATH`, `USE_TYPE`, `SIZE_CATEGORY_ID`, `SIZE_INFO_ID`, `PUBLIC_FLAG`, `A_ID`, `U_ID`)
VALUE ('{$_POST['CONTENTS_NAME']}', {$_POST['THEME_ID']}, '{$_POST['KEYWORD']}',
 '{$_POST['THUMB_PATH']}', '{$_POST['CONTENTS_PATH']}', {$_POST['USE_TYPE']}, {$_POST['SIZE_CATEGORY_ID']},
 {$_POST['SIZE_INFO_ID']}, {$_POST['PUBLIC_FLAG']}, {$_POST['A_ID']}, {$_POST['U_ID']})";
}

post($conn, $sql);

echo json_encode($data);

mysqli_close($conn);
