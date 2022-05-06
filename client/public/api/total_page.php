<?php

include("connect.php");

$query = $conn->query("SELECT count(SEQ_ID) FROM tb_project");
$totalRecords = $query->fetch_row()[0];
$total = floor($totalRecords/10);
echo json_encode($total);

mysqli_close($conn);

?>