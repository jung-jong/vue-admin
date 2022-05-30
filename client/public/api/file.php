<?php
include("connect.php");
header("Content-Type:text/html;charset=utf-8");

if (isset($_POST['id'])) {
  $sql = "SELECT * FROM TB_MY_UPLOAD WHERE FILE_DIR = '{$_POST['id']}'";
  
  $result = mysqli_query($conn, $sql);

  $data = array();
  while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
  }
}

$idx=0;
$storage = 0;

foreach($data as $row)
{
    $id = $data[$idx]["FILE_DIR"];
    $file_name = $data[$idx]["FILE_NAME"];
    $file_dir = "../user/{$id}/upload/{$file_name}";
    $file_size = filesize($file_dir);
    // $file_size = format_size($file_size);

    $data[$idx]["FILE_SIZE"] = $file_size;

    $storage += $data[$idx]["FILE_SIZE"];

    $idx++;
    
}

function format_size($size) {
  $sizes = array("Byte", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
  if ($size == 0) {
       return('n/a');
  } else {
       return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]);
  }
}

mysqli_close($conn);
echo json_encode($data);

?>