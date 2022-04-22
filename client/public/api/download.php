<?php
include("connect.php");

$file_dir = "{$_POST['FILE_DIR']}";
$file_name = "{$_POST['FILE_NAME']}";
$reail_filename = urldecode("{$_POST['FILE_NAME']}");
$file_path = "../user_data/{$file_dir}/{$file_name}";

header('Content-Type: application/x-octetstream');
header('Content-Length: '.filesize($file_path));
header('Content-Disposition: attachment; filename='.$reail_filename);
header('Content-Transfer-Encoding: binary');

$fp = fopen($file_path, "r");
fpassthru($fp);
fclose($fp);

?>