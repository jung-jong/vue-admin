<?php

include("connect.php");

if (isset($_GET['template'])) {
  $sql = "SELECT * FROM TB_SIZE WHERE SIZE_CATEGORY_ID = {$_GET['template']} ORDER BY `ORDER` ASC";
}

if (isset($_GET['size'])) {
  $sql = "SELECT * FROM TB_SIZE WHERE SEQ_ID = {$_GET['size']} ORDER BY `ORDER` ASC";
}

$result = mysqli_query($conn, $sql);
$data = array();
while($row = mysqli_fetch_assoc($result)){
  $data[] = $row;
}

echo json_encode($data);

mysqli_close($conn);

?>