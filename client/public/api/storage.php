<?php

//디렉토리 목록
$id = array();
$i=0;
if ($handle = opendir('../user_data')) {
  while (false !== ($dir = readdir($handle))) {
    if ($dir != "." && $dir != "..") {
      $folder[$i] = $dir;
      $id[$i]["ID"]= $dir;
      $id[$i]["USE_STORAGE"] = 0;
      $id[$i]["FILE_NUMS"] = 0;
      $i++;
    }
  }
  closedir($handle);
}
// 디렉토리 사용량
$idx=0;
foreach ($id as $key => $value) {
  $file_dir = $id[$idx]["ID"];
  foreach (glob("../user_data/{$file_dir}/*") as $filename) {
    // echo $idx."\n";
    // echo $filename."\n";
    $file_size = filesize($filename);
    // echo $use."\n";
    $id[$idx]["USE_STORAGE"] += $file_size;
    $id[$idx]["FILE_NUMS"] += 1;
  }
  $idx++;
}

echo json_encode($id);

?>