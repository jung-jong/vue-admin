<?php
include("connect.php");


$sql = "SELECT * FROM tb_project";
//전체조회
if(!isset($_GET['id'])){
  $result = mysqli_query($conn, $sql);
  $data = array();
  while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
  }
}
//?ID=조회
if(isset($_GET['id'])){
  $sql ="SELECT * FROM `tb_project` WHERE `SEQ_ID`={$_GET['id']}";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $data[] = $row;
}

echo json_encode($data);
// 배열형식의 결과를 json으로 변환 
// json파일 생성
// $json = json_encode(($result),JSON_UNESCAPED_UNICODE);
// DB 접속 종료 
mysqli_close($conn);

?>