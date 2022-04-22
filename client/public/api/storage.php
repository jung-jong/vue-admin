<?php
//tb_file 테이블
$files = array();
$i=0;
if ($handle = opendir('../user_data')) {
  while (false !== ($dir = readdir($handle))) {
    if ($dir != "." && $dir != "..") {
      $file_dir[$i] = $dir;
      $files[$i]["FILE_DIR"]= $dir;
      $i++;
    }
  }
  closedir($handle);
}
$idx=0;
//파일 디렉토리
foreach ($files as $value) {

  $file_dir = $files[$idx]["FILE_DIR"];
  if($handle = opendir("../user_data/{$file_dir}")){
    while (false !== ($dir = readdir($handle))) {
      if ($dir != "." && $dir != "..") {
        $file[$idx] = $dir;
      }
    }
  }
  echo json_encode($handle);
  closedir($handle);

  $idx++;
}
//하위 디렉토리 파일 수
$num = array_count_values($count);
//값만 반환
$num_value = array_values($num);

// $storage = array_merge($files, $num_value);


  // 디렉토리에 있는 파일과 디렉토리의 갯수 구하기

// foreach ($file_dir as $value) {
//   $result=opendir("../user_data/{$value}"); //opendir함수를 이용해서 bbs디렉토리의 핸들을 얻어옴
  
//   // readdir함수를 이용해서 bbs디렉토리에 있는 디렉토리와 파일들의 이름을 배열로 읽어들임
//   while($file=readdir($result)) {
      
//     if($file=="."||$file=="..") {continue;} // file명이 ".", ".." 이면 무시함
//     $fileInfo = pathinfo($file);
//     $fileExt = $fileInfo['extension']; // 파일의 확장자를 구함
  
//     if (empty($fileExt)){
//       $dir_count++; // 파일에 확장자가 없으면 디렉토리로 판단하여 dir_count를 증가시킴
//     } else {
//       $file_count++;// 파일에 확장자가 있으면 file_count를 증가시킴
//     }
//   }
// }
// echo"파일의 갯수는:".$file_count;


// $i=0;
// foreach ($files as $value) {
//   # code...
//   $files[]["COUNT"] = $count;
//   $i++;
// }


// $num = print_r(array_count_values($count));
// echo json_encode(array_count_values($count));
// echo json_encode($value);

?>