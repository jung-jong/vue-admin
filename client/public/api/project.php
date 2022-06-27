<?php
include("connect.php");
include("axios.php");

$sql = "SELECT * FROM TB_PROJECT";

if (
  isset($_GET['search']) && !empty($_GET['search'])
  && isset($_GET['id'])
) {
  $search = $_GET['search'];
  $sql .= " WHERE USER_ID LIKE '%$search%'";
  get($conn, $sql);
} else if (
  isset($_GET['search']) && !empty($_GET['search'])
  && isset($_GET['title'])
) {
  $search = $_GET['search'];
  $sql .= " WHERE TITLE LIKE '%$search%'";
  get($conn, $sql);
} else if (
  isset($_GET['search']) && !empty($_GET['search'])
  && isset($_GET['width'])
) {
  $search = $_GET['search'];
  $sql .= " WHERE WIDTH LIKE '%$search%' OR HEIGHT LIKE '%$search%'";
  get($conn, $sql);
}

if (isset($_GET['start'])) {
  $start = $_GET['start'];
  $length = $_GET['length'];
  $sql .= " LIMIT $start, $length";
  get($conn, $sql);
}

if (isset($_POST['SEQ_ID'])) {
  $sql = "DELETE FROM TB_PROJECT WHERE SEQ_ID = {$_POST['SEQ_ID']}";
  post($conn, $sql);
}

echo json_encode($data);

mysqli_close($conn);
