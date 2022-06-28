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
include("axios.php");

if (isset($_GET['id'])) {
  $sql = "SELECT * FROM `TB_CONTENTS` WHERE `THEME_ID` = {$_GET['id']}";
}

get($conn, $sql);

echo json_encode($data);

mysqli_close($conn);
