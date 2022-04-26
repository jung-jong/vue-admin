<?php
include("connect.php");
header("Content-Type:text/html;charset=utf-8");

$sql = "SELECT * FROM TB_FILE WHERE SEQ_ID = '{$_POST['SEQ_ID']}'";

$result = mysqli_query($conn, $sql);

mysqli_close($conn);

$data = array();
while($row = mysqli_fetch_assoc($result)){
  $data[] = $row;
}


// $file_name = "{$data[0]["FILE_NAME"]}";
// $filepath = "../user_data/{$id}/{$file_name}";

$id = "{$data[0]["FILE_DIR"]}";
$filename = "{$data[0]["FILE_NAME"]}";
$reail_filename = urldecode($filename);
$file_dir = "../user_data/{$id}/{$filename}";

header('Content-Type: application/x-octetstream');
header('Content-Length: '.filesize($file_dir));
header('Content-Disposition: attachment; filename='.$reail_filename);
header('Content-Transfer-Encoding: binary');

$fp = fopen($file_dir, "r");
fpassthru($fp);
fclose($fp);


// echo $filepath;
// echo json_encode($filepath);
// echo json_encode($data[0]["FILE_DIR"]);

?>