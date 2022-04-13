<?php
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Credentials", "true");
header('Access-Control-Allow-Headers", "Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers');
header('Access-Control-Allow-Methods:GET,POST,PUT,DELETE,OPTIONS');

$db_host = "localhost:3307";
$db_user = "root";
$db_password="wjdwhdgus1";
$db_name="test";
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$conn) {
  die("MariaDB 접속 실패: " . mysqli_connect_error());
}

$sql = "SELECT  `SEQ_ID`,  `USER_ID`,  `TITLE`, `PAGE_LIST`, `DESCRIPTION`,  `SCALE_CD`,  `WIDTH`,  `HEIGHT`,  `SHARE_URL`,  `PUBLIC_FLAG`,
  `DEL`,  `A_ID`,  `U_ID`,  `D_ID`,  `A_DATE`,  `U_DATE`,  `D_DATE` FROM `test`.`tb_project`";
$res = mysqli_query($conn, $sql); 
$result = array(); 

while($row = mysqli_fetch_array($res)) 
{ array_push($result, array(
  "id"=>$row[0], "USER_ID"=>$row[1], "TITLE"=>$row[2], "PAGE_LIST"=>$row[3], "DESCRIPTION"=>$row[4],
    "SCALE_CD"=>$row[5],"WIDTH"=>$row[6],"HEIGHT"=>$row[7],"SHARE_URL"=>$row[8],
    "PUBLIC_FLAG"=>$row[9], "DEL"=>$row[10], "A_ID"=>$row[11], "U_ID"=>$row[12], "D_ID"=>$row[13],
    "A_DATE"=>$row[14], "U_DATE"=>$row[15], "D_DATE"=>$row[16]
)); } 

echo json_encode(($result),JSON_UNESCAPED_UNICODE);
// json파일 생성
// $json = json_encode(($result),JSON_UNESCAPED_UNICODE);
// file_put_contents("project.json",$json);
mysqli_close($conn); 

?>