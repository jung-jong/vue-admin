<?php

include("connect.php");

if (isset($_POST['NEXT'])) {
  $sql = "UPDATE `TB_SIZE_CATEGORY`
  SET `ORDER` = {$_POST['ORDER']}
  WHERE `SEQ_ID` = {$_POST['NEXT']}";
}

if (isset($_POST['PREV'])) {
  $sql = "UPDATE `TB_SIZE_CATEGORY`
  SET `ORDER` = {$_POST['ORDER']}
  WHERE `SEQ_ID` = {$_POST['PREV']}";
}

$result = mysqli_query($conn, $sql);
$data = array();
while($row = mysqli_fetch_assoc($result)){
  $data[] = $row;
}

echo json_encode($data);

mysqli_close($conn);

?>