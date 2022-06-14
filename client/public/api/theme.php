<?php

include("connect.php");

$sql = "SELECT * FROM `TB_THEME` WHERE `CONTENTS_CATEGORY_ID` = {$_GET['contents']} ORDER BY `ORDER` ASC";

if (isset($_GET['start'])) {
  $start = $_GET['start'];
  $length = $_GET['length'];
  $sql .= " LIMIT $start, $length";
}

$result = mysqli_query($conn, $sql);
$data = array();
while($row = mysqli_fetch_assoc($result)){
  $data[] = $row;
}

echo json_encode($data);

mysqli_close($conn);