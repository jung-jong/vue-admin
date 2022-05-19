<?php

include("connect.php");

$sql = "UPDATE `TB_SIZE_CATEGORY`
 SET `ORDER` = {$_POST['ORDER']}
 WHERE `SEQ_ID` = {$_POST['SEQ_ID']}";

$result = mysqli_query($conn, $sql);
$data = array();
while($row = mysqli_fetch_assoc($result)){
  $data[] = $row;
}

echo json_encode($data);

mysqli_close($conn);

?>