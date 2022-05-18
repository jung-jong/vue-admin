<?php

include("connect.php");

$sql = "SELECT * FROM TB_SIZE_CATEGORY";

$result = mysqli_query($conn, $sql);
$data = array();
while($row = mysqli_fetch_assoc($result)){
  $data[] = $row;
}

$marks = array();
foreach ($data as $key => $value) {
  $marks[$key] = $value['ORDER'];
}

array_multisort($marks, SORT_ASC, $data);

echo json_encode($data);

mysqli_close($conn);

?>