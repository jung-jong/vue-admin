<?php

include("connect.php");
include("axios.php");

$sql = "SELECT * FROM TB_USER_STATUS WHERE USER_LEVEL = '1' OR USER_LEVEL = '2'";

if (isset($_GET['search']) && !empty($_GET['search'])
    && isset($_GET['id'])) {
  $search = $_GET['search'];
  $sql = "SELECT * FROM TB_USER_STATUS WHERE USER_ID LIKE '%$search%' AND NOT USER_LEVEL = '9'";

} 

if (isset($_GET['start'])) {
  $start = $_GET['start'];
  $length = $_GET['length'];
  $sql .= " LIMIT $start, $length";
}

get($conn, $sql);

echo json_encode($data);

mysqli_close($conn);
