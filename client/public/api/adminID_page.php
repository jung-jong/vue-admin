<?php

include("connect.php");

if (!isset($_GET['id'])) {
  $query = $conn->query("SELECT count(SEQ_ID) FROM tb_user_status WHERE USER_LEVEL = '1' OR USER_LEVEL = '2'");
}

if (isset($_GET['id'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(SEQ_ID) FROM tb_user_status WHERE USER_LEVEL = '1' OR USER_LEVEL = '2' AND USER_ID LIKE '%$search%'");
}

$totalRecords = $query->fetch_row()[0];
$total = ceil($totalRecords/10);
echo json_encode($total);

mysqli_close($conn);

?>