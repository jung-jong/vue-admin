<?php
include("connect.php");

header('Content-Type: text/html; charset=utf-8');

$sql = "SELECT * FROM TB_FILE WHERE SEQ_ID = '{$_POST['SEQ_ID']}'";

$result = mysqli_query($conn, $sql);

mysqli_close($conn);

$data = array();
while($row = mysqli_fetch_assoc($result)){
  $data[] = $row;
}

$id = "{$data[0]["FILE_DIR"]}";
$filename = "{$data[0]["FILE_NAME"]}";
//$enc = mb_detect_encoding($filename, array("UTF-8", "EUC-KR", "SJIS"));
//echo $enc;
//echo $filename;
// $filename = utf2euc($filename);


// $file_dir = "../user_data/{$id}/{$filename}";

$file_dir = "user_data/{$id}/{$filename}";
echo $file_dir;

// header("Content-Type: application/octet-stream");
// header('Content-Length: '.filesize($file_dir));
// header("Content-Disposition: attachment; filename=".$filename);
// header('Content-Transfer-Encoding: binary');

// readfile($file_dir);

function utf2euc($str) { return iconv("UTF-8","CP949", $str); }
// function utf2euc($str) { return iconv("UTF-8","cp949", "한글1234"); }



?>