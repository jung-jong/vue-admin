<?php
include("connect.php");

$sql = "SELECT * FROM TB_FILE";

$result = mysqli_query($conn, $sql);
$data = array();
while($row = mysqli_fetch_assoc($result)){
  $data[] = $row;
}

if (isset($_POST["SEQ_ID"])) {
  $user_id = isset($_POST['USER_ID']);
  $file_name = isset($_POST['FILE_DIR']);
  $file_url = "http://nemolabs.iptime.org:1080/admin/upload/$user_id/$file_name";
  echo pathinfo($file_url, PATHINFO_DIRNAME); // 상위, 루트 경로를 반환
  echo $file_url;
};

echo json_encode($data);
mysqli_close($conn);

?>