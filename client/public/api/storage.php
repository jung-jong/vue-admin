<?php
include("connect.php");

//tb_file 테이블
// $sql = "SELECT FILE_DIR FROM tb_file";

// $result = mysqli_query($conn, $sql);

// $data = array();
// while($row = mysqli_fetch_assoc($result)){
//   $data[] = $row;
// }

//디렉토리 목록
$id = array();
$i=0;
if ($handle = opendir('../user_data')) {
  while (false !== ($dir = readdir($handle))) {
    if ($dir != "." && $dir != "..") {
      $folder[$i] = $dir;
      $id[$i]["ID"]= $dir;
      $i++;
    }
  }
  closedir($handle);
}

// echo json_encode($id);
//디렉토리 사용량
$idx=0;
foreach ($id as $key => $value) {
  $file_dir = $id[$idx]["ID"];
  foreach (glob("../user_data/{$file_dir}/*") as $filename) {
    // echo $idx."\n";
    // echo $filename."\n";
    $file_size = filesize($filename)/1024/1024;
    $use = round($file_size, 3);
    echo $use."\n";
    $id[$idx]["USE_STORAGE"] += $use;
    $id[$idx]["FILE_NUMS"] += 1;
    
  }
  $idx++;
}
echo json_encode($id);



// $storage = array_merge($data, $id);

// $count = array_count_values($data);


// echo json_encode($id);

mysqli_close($conn);

?>