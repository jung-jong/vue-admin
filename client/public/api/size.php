<?php

include("connect.php");

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
  SET `PAGE_WIDTH` = {$_POST['PAGE_WIDTH']}, `PAGE_HEIGHT` = {$_POST['PAGE_HEIGHT']}, `SCALE_CD` = {$_POST['SCALE_CD']}
  WHERE `SEQ_ID` = {$_POST['SEQ_ID']}";
  post($conn, $sql);
}

function get($conn, $sql)
{
  global $data;
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }
}

function post($conn, $sql)
{
  global $data;
  $result = mysqli_query($conn, $sql);
  if ($result == false) {
    error_log(mysqli_error($conn));
    $data = array('DB' => "error");
  } else {
    $data = array('DB' => "success");
  }
}

echo json_encode($data);

mysqli_close($conn);
