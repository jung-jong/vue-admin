<?php

include("connect.php");

$sql = "INSERT INTO TB_SIZE_CATEGORY (`TEMPLATE_TYPE_NAME`, `ORDER`, `A_ID`, `U_ID`)
 VALUES ('{$_POST['TEMPLATE_TYPE_NAME']}', {$_POST['ORDER']}, 0, 0)";

$result = mysqli_query($conn, $sql);
$data = array();
while($row = mysqli_fetch_assoc($result)){
  $data[] = $row;
}

echo json_encode($data);

mysqli_close($conn);

?>