<?php
$db_host = "localhost:3307";
$db_user = "root";
$db_password="wjdwhdgus1";
$db_name="test";
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
echo "MariaDB 접속 성공<br><br>";
if (!$conn) {
  die("MariaDB 접속 실패: " . mysqli_connect_error());
}

$sql = "SELECT  `SEQ_ID`,  `USER_ID`,  `TITLE`, `PAGE_LIST`,  `SCALE_CD`,  `WIDTH`,  `HEIGHT`,  `SHARE_URL`,  `PUBLIC_FLAG`,
  `DEL`,  `A_ID`,  `U_ID`,  `D_ID`,  `A_DATE`,  `U_DATE`,  `D_DATE` FROM `test`.`tb_project`";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_array($result)) {
    echo "id: " . $row["SEQ_ID"]. " USER_ID: " . $row["USER_ID"]. " TITLE: " . $row["TITLE"]. "PAGE_LIST: ".$row["PAGE_LIST"]. 
    "SCALE_CD: " .$row["SCALE_CD"]. "WIDTH: " .$row["WIDTH"]. "HEIGHT: ".$row["HEIGHT"]. "SHARE_URL: " .$row["SHARE_URL"]. 
    "PUBLIC_FLAG: " .$row["PUBLIC_FLAG"]. "DEL: " .$row["DEL"]. "A_ID: " .$row["A_ID"]. "U_ID: ".$row["U_ID"]. "D_ID: " .$row["D_ID"].
    "A_DATE: " .$row["A_DATE"]. "U_DATE: " .$row["U_DATE"]. "D_DATE: " .$row["D_DATE"]."<br><br>";
  } 
} else {
  echo "결과없음";
}
echo mysqli_num_rows($result)."건이 조회됨<br>";
mysqli_close($conn);
?>