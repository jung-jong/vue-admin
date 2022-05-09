<?php

include("connect.php");

if (!isset($_GET['id'])) {
  $query = $conn->query("SELECT count(SEQ_ID) FROM tb_project");
}

if (isset($_GET['id'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM tb_project WHERE USER_ID LIKE '%$search%'");
}

if (isset($_GET['title'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM tb_project WHERE TITLE LIKE '%$search%'");
}

if (isset($_GET['width'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM tb_project WHERE WIDTH OR HEIGHT LIKE '%$search%'");
}

$totalRecords = $query->fetch_row()[0];
$total = ceil($totalRecords/10);
echo json_encode($total);

mysqli_close($conn);

?>