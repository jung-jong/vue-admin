<?php

include("connect.php");

if (!isset($_POST['PUBLIC_FLAG'])) {
  $sql = "SELECT * FROM TB_SIZE_CATEGORY ORDER BY `ORDER` ASC";

  $result = mysqli_query($conn, $sql);
  $data = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }
}

if (isset($_POST['PUBLIC_FLAG'])) {
  $sql = "UPDATE `TB_SIZE_CATEGORY`
  SET `PUBLIC_FLAG` = {$_POST['PUBLIC_FLAG']}, `U_DATE` = CURRENT_TIMESTAMP()
  WHERE `SEQ_ID` = {$_POST['SEQ_ID']}";

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
