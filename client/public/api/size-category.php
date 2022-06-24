<?php

include("connect.php");

if (
  !isset($_POST['TEMPLATE_TYPE_NAME']) &&
  !isset($_POST['deleteTemplate']) &&
  !isset($_POST['PUBLIC_FLAG'])
) {
  $sql = "SELECT * FROM TB_SIZE_CATEGORY ORDER BY `ORDER` ASC";
  $result = mysqli_query($conn, $sql);
  $data = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }
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
