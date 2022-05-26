<?php

include("connect.php");

$sql = "SELECT * FROM TB_SIZE_CATEGORY ORDER BY `ORDER` ASC";

$result = mysqli_query($conn, $sql);
$data = array();
while($row = mysqli_fetch_assoc($result)){
  $data[] = $row;
}

echo json_encode($data);

mysqli_close($conn);

?>