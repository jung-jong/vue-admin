<?php
include("connect.php");

$sql = "SELECT * FROM TB_PROJECT";

if (isset($_GET['start'])) {
  $start = $_GET['start'];
  $length = $_GET['length'];
  $sql .= " LIMIT $start, $length";
}

//전체조회
if(!isset($_GET['id'])){
  $result = mysqli_query($conn, $sql);
  $data = array();
  while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
  }
}

if (isset($_GET['search']) && !empty($_GET['search'])
    && isset($_GET['selected'])) {
  $search = $_GET['search'];
  $USER_ID = $_GET['selected'];
  $sql .= " WHERE $USER_ID LIKE '%$search%' OR TITLE LIKE '%$search%' OR SCALE_CD LIKE '%$search%' OR 
  WIDTH LIKE '%$search%' OR HEIGHT LIKE '%$search%'";
}

//?ID=조회
if(isset($_GET['id'])){
  $sql ="SELECT * FROM `TB_PROJECT` WHERE `SEQ_ID`={$_GET['id']}";
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