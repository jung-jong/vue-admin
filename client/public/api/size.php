<?php

include("connect.php");

if (isset($_GET['template'])) {
  $sql = "SELECT * FROM TB_SIZE WHERE SIZE_CATEGORY_ID = {$_GET['template']}";
}

if (isset($_GET['size'])) {
  $sql = "SELECT * FROM TB_SIZE WHERE SEQ_ID = {$_GET['size']}";
}

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