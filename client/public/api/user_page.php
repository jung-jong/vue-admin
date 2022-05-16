<?php

include("connect.php");

if (!isset($_GET['id'])) {
  $query = $conn->query("SELECT count(SEQ_ID) FROM TB_USER_STATUS");
}

if (isset($_GET['id'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM TB_USER_STATUS WHERE USER_ID LIKE '%$search%'");
}

if (isset($_GET['lisense'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM TB_USER_STATUS WHERE LICENSE_TYPE LIKE '%$search%'");
}

if (isset($_GET['status'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM TB_USER_STATUS WHERE USER_STATUS LIKE '%$search%'");
}

if (isset($_GET['lastWork'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM TB_USER_STATUS WHERE LAST_WORK_DATE LIKE '%$search%'");
}

if (isset($_GET['lastDown'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM TB_USER_STATUS WHERE LAST_WORK_DATE LIKE '%$search%'");
}

if (isset($_GET['storage'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM TB_USER_STATUS WHERE STORAGE_USE LIKE '%$search%'");
}

if (isset($_GET['file'])) {
  $search = $_GET['search'];
  $query = $conn->query("SELECT count(*) FROM TB_USER_STATUS WHERE STORAGE_USE LIKE '%$search%'");
}




$totalRecords = $query->fetch_row()[0];
$total = ceil($totalRecords/10);
echo json_encode($total);

mysqli_close($conn);

?>