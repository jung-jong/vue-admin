<?php
include("connect.php");

$sql = "SELECT * FROM TB_PROJECT";

if (isset($_GET['search']) && !empty($_GET['search'])
    && isset($_GET['id'])) {
  $search = $_GET['search'];
  $sql .= " WHERE USER_ID LIKE '%$search%'";

} else if(isset($_GET['search']) && !empty($_GET['search'])
&& isset($_GET['title'])){
  $search = $_GET['search'];
  $sql .= " WHERE TITLE LIKE '%$search%'";
  
} else if(isset($_GET['search']) && !empty($_GET['search'])
&& isset($_GET['width'])){
  $search = $_GET['search'];
  $sql .= " WHERE WIDTH LIKE '%$search%' OR HEIGHT LIKE '%$search%'";
  
}

if (isset($_GET['start'])) {
  $start = $_GET['start'];
  $length = $_GET['length'];
  $sql .= " LIMIT $start, $length";
}

//전체조회
$result = mysqli_query($conn, $sql);
$data = array();
while($row = mysqli_fetch_assoc($result)){
  $data[] = $row;
}

echo json_encode($data);
// 배열형식의 결과를 json으로 변환 
// json파일 생성
// $json = json_encode(($result),JSON_UNESCAPED_UNICODE);
// DB 접속 종료 
mysqli_close($conn);

?>