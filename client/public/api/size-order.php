<?php

include("connect.php");
include("axios.php");

if (isset($_POST['SEQ_ID'])) {
  $sql = "UPDATE `TB_SIZE`
  SET `ORDER` = {$_POST['ORDER']}
  WHERE `SEQ_ID` = {$_POST['SEQ_ID']}";
}

if (isset($_POST['NEXT'])) {
  $sql = "UPDATE `TB_SIZE`
  SET `ORDER` = {$_POST['ORDER']}
  WHERE `SEQ_ID` = {$_POST['NEXT']}";
}

if (isset($_POST['PREV'])) {
  $sql = "UPDATE `TB_SIZE`
  SET `ORDER` = {$_POST['ORDER']}
  WHERE `SEQ_ID` = {$_POST['PREV']}";
}

get($conn, $sql);

echo json_encode($data);

mysqli_close($conn);
