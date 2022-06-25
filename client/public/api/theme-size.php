<?php

include("connect.php");

if (
  !isset($_GET['template']) &&
  !isset($_GET['size'])
) {
  $sql = "SELECT * FROM TB_SIZE_CATEGORY WHERE `PUBLIC_FLAG` = 1 ORDER BY `ORDER` ASC";
  get($conn, $sql);
}

if (isset($_GET['template'])) {
  $sql = "SELECT * FROM TB_SIZE WHERE `SIZE_CATEGORY_ID` = {$_GET['template']} AND `PUBLIC_FLAG` = 1 ORDER BY `ORDER` ASC";
  get($conn, $sql);
}

if (isset($_GET['size'])) {
  $sql = "SELECT * FROM TB_SIZE WHERE `SEQ_ID` = {$_GET['size']} AND `PUBLIC_FLAG` = 1 ORDER BY `ORDER` ASC";
  get($conn, $sql);
}

function get($conn, $sql)
{
  global $data;
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }
}

echo json_encode($data);

mysqli_close($conn);
