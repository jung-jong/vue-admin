<?php

include("connect.php");

$query = $conn->query("SELECT count(SEQ_ID) FROM TB_THEME");

$totalRecords = $query->fetch_row()[0];
$total = ceil($totalRecords);
echo json_encode($total);

mysqli_close($conn);

?>