<?php
include("connect.php");

if (isset($_POST['id'])) {
  $sql = "SELECT * FROM TB_FILE WHERE FILE_DIR = '{$_POST['id']}'";
  
  $result = mysqli_query($conn, $sql);
  $data = array();
  while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
  }
}


if (isset($_POST["FILE_DIR"])) {
  $file_dir = "{$_POST['FILE_DIR']}";
  $file_name = "{$_POST['FILE_NAME']}";
  // $file_url = "http://nemolabs.iptime.org:1080/admin/upload/{$file_dir}/{$file_name}";
  $file_url = "../upload/{$file_dir}/{$file_name}";
  $file_size = filesize($file_url);
  $data = floor($file_size);
};

echo json_encode($data);
mysqli_close($conn);

?>