<?php

include("connect.php");
include("axios.php");

if (isset($_POST['SEQ_ID'])) {
  $sql = "UPDATE `TB_THEME`
  SET `ORDER` = {$_POST['ORDER']}, `U_DATE` = CURRENT_TIMESTAMP()
  WHERE `SEQ_ID` = {$_POST['SEQ_ID']}";
}

if (isset($_POST['NEXT'])) {
  $sql = "UPDATE `TB_THEME`
  SET `ORDER` = {$_POST['ORDER']}, `U_DATE` = CURRENT_TIMESTAMP()
  WHERE `SEQ_ID` = {$_POST['NEXT']}";
}

if (isset($_POST['PREV'])) {
  $sql = "UPDATE `TB_THEME`
  SET `ORDER` = {$_POST['ORDER']}, `U_DATE` = CURRENT_TIMESTAMP()
  WHERE `SEQ_ID` = {$_POST['PREV']}";
}

post($conn, $sql);

echo json_encode($data);

mysqli_close($conn);
