<?php

if (isset($_POST['CONTENTS_PATH'])) {
  $dir = "." . $_POST['CONTENTS_PATH'];

  if (!file_exists($dir)) {
    echo "파일을 찾지 못함";
  }

  $json = json_decode(file_get_contents($dir), true);

  echo json_encode($json);

  exit;
}


include("connect.php");

if (isset($_GET['id'])) {
  $sql = "SELECT * FROM `TB_CONTENTS` WHERE `THEME_ID` = {$_GET['id']}";
}

if (isset($_GET['size-category'])) {
  $sql = "SELECT * FROM `TB_SIZE_CATEGORY` WHERE `SEQ_ID` = {$_GET['size-category']}";
}

if (isset($_GET['size'])) {
  $sql = "SELECT * FROM `TB_SIZE` WHERE `SEQ_ID` = {$_GET['size']}";
}

$result = mysqli_query($conn, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

echo json_encode($data);

mysqli_close($conn);
