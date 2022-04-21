<?php
include("connect.php");
header("Content-Type:text/html;charset=utf-8");

if (isset($_POST['id'])) {
  $sql = "SELECT * FROM TB_FILE WHERE FILE_DIR = '{$_POST['id']}'";
  
  $result = mysqli_query($conn, $sql);

  $data = array();
  while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;



  }

}

/*
  $file_dir = $data['FILE_DIR']}";
    $file_name = "{$_POST['FILE_NAME']}";
    $file_url = "../user_data/{$file_dir}/{$file_name}";
    $file_size = filesize($file_url)/1024;
    $file_size = floor($file_size);
*/

$idx=0;
foreach($data as $row)
{
    //print_r( $row );
    //echo $row;
    $file_dir = $data[$idx]["FILE_DIR"];
    $file_name = $data[$idx]["FILE_NAME"];
    $file_url = "../user_data/{$file_dir}/{$file_name}";
    $file_size = filesize($file_url)/1024;
    $file_size = floor($file_size);

    $data[$idx]["FILE_SIZE"] = $file_size;

    $idx++;
    
}



// if (isset($_POST["FILE_DIR"])) {
//   $file_dir = "{$_POST['FILE_DIR']}";
//   $file_name = "{$_POST['FILE_NAME']}";
//   // $file_url = "http://nemolabs.iptime.org:1080/admin/upload/{$file_dir}/{$file_name}";
//   $file_url = "../user_data/{$file_dir}/{$file_name}";
//   $file_size = filesize($file_url)/1024;
//   $data = floor($file_size);

//   // $data = array();
//   // while($row = array($file_size)){
//   //   $data[] = $row;
//   // }
// };

mysqli_close($conn);
echo json_encode($data);

?>