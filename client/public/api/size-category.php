<?php

include("connect.php");
include("axios.php");

if (
  !isset($_POST['TEMPLATE_TYPE_NAME']) &&
  !isset($_POST['deleteTemplate']) &&
  !isset($_POST['PUBLIC_FLAG'])
) {
  $sql = "SELECT * FROM TB_SIZE_CATEGORY ORDER BY `ORDER` ASC";
  get($conn, $sql);
}

if (isset($_POST['TEMPLATE_TYPE_NAME'])) {
  $sql = "INSERT INTO TB_SIZE_CATEGORY (`TEMPLATE_TYPE_NAME`, `ORDER`, `A_ID`, `U_ID`)
  VALUES ('{$_POST['TEMPLATE_TYPE_NAME']}', {$_POST['ORDER']}, 0, 0)";

  post($conn, $sql);
}

if (isset($_POST['deleteTemplate'])) {
  $sql = "DELETE FROM `TB_SIZE_CATEGORY` WHERE `SEQ_ID` = {$_POST['deleteTemplate']}";
  post($conn, $sql);
}

if (isset($_POST['PUBLIC_FLAG'])) {
  $sql = "UPDATE `TB_SIZE_CATEGORY`
  SET `PUBLIC_FLAG` = {$_POST['PUBLIC_FLAG']}, `U_DATE` = CURRENT_TIMESTAMP()
  WHERE `SEQ_ID` = {$_POST['SEQ_ID']}";

  post($conn, $sql);
}

echo json_encode($data);

mysqli_close($conn);
