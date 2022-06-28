<?php

include("connect.php");
include("axios.php");

if (isset($_GET['template'])) {
  $sql = "SELECT * FROM TB_SIZE WHERE SIZE_CATEGORY_ID = {$_GET['template']} ORDER BY `ORDER` ASC";
  get($conn, $sql);
}

if (isset($_GET['size'])) {
  $sql = "SELECT * FROM TB_SIZE WHERE SEQ_ID = {$_GET['size']} ORDER BY `ORDER` ASC";
  get($conn, $sql);
}

if (isset($_POST['addSize'])) {
  $sql = "INSERT INTO `TB_SIZE` (`SIZE_CATEGORY_ID`, `SIZE_NAME`, `ORDER`, `A_ID`, `U_ID`)
  VALUES ({$_POST['SIZE_CATEGORY_ID']}, '{$_POST['addSize']}', {$_POST['ORDER']}, 0, 0)";
  post($conn, $sql);
}

if (isset($_POST['deleteTemplate'])) {
  $sql = "DELETE FROM `TB_SIZE` WHERE `SIZE_CATEGORY_ID` = {$_POST['SIZE_CATEGORY_ID']}";
  post($conn, $sql);
}

if (isset($_POST['deleteSize'])) {
  $sql = "DELETE FROM `TB_SIZE` WHERE `SEQ_ID` = {$_POST['deleteSize']}";
  post($conn, $sql);
}

if (isset($_POST['PUBLIC_FLAG'])) {
  $sql = "UPDATE `TB_SIZE`
  SET `PUBLIC_FLAG` = {$_POST['PUBLIC_FLAG']}, `U_DATE` = CURRENT_TIMESTAMP()
  WHERE `SEQ_ID` = {$_POST['SEQ_ID']}";
  post($conn, $sql);
}

if (isset($_POST['PAGE_WIDTH'])) {
  $sql = "UPDATE `TB_SIZE`
  SET `PAGE_WIDTH` = {$_POST['PAGE_WIDTH']}, `PAGE_HEIGHT` = {$_POST['PAGE_HEIGHT']},
   `SCALE_CD` = {$_POST['SCALE_CD']}, `U_DATE` = CURRENT_TIMESTAMP()
  WHERE `SEQ_ID` = {$_POST['SEQ_ID']}";
  post($conn, $sql);
}

echo json_encode($data);

mysqli_close($conn);
