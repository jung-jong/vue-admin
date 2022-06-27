<?php

include("connect.php");
include("axios.php");

if (!isset($_GET['contents'])) {
  $sql = "SELECT * FROM TB_CONTENTS_CATEGORY";
}

if (isset($_GET['contents'])) {
  $sql = "SELECT * FROM `TB_THEME` WHERE `CONTENTS_CATEGORY_ID` = {$_GET['contents']} ORDER BY `ORDER` ASC";
}

if (isset($_GET['start'])) {
  $start = $_GET['start'];
  $length = $_GET['length'];
  $sql .= " LIMIT $start, $length";
}

get($conn, $sql);

echo json_encode($data);

mysqli_close($conn);
