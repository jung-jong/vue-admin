<?php

include("connect.php");

if (!isset($_GET['id'])) {
  $query = $conn->query("SELECT count(SEQ_ID) FROM tb_user_status");
}

if (isset($_GET['id'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM tb_user_status WHERE USER_ID LIKE '%$search%'");
}

if (isset($_GET['lisense'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM tb_user_status WHERE LICENSE_TYPE LIKE '%$search%'");
}

if (isset($_GET['status'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM tb_user_status WHERE USER_STATUS LIKE '%$search%'");
}

if (isset($_GET['lastWork'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM tb_user_status WHERE LAST_WORK_DATE LIKE '%$search%'");
}

if (isset($_GET['lastDown'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM tb_user_status WHERE LAST_WORK_DATE LIKE '%$search%'");
}

if (isset($_GET['storage'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM tb_user_status WHERE STORAGE_USE LIKE '%$search%'");
}

if (isset($_GET['file'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM tb_user_status WHERE STORAGE_USE LIKE '%$search%'");
}




$totalRecords = $query->fetch_row()[0];
$total = ceil($totalRecords/10);
echo json_encode($total);

mysqli_close($conn);

?>