<?php

include("connect.php");

if (isset($_GET['search']) && !empty($_GET['search'])) {
  $search = $_GET['search'];
  $sql = "SELECT USER_ID, USER_LEVEL FROM TB_USER_STATUS WHERE
  USER_LEVEL = 9 AND USER_ID LIKE '$search'";
} 

if (isset($_POST['id'])) {
  $id = $_POST['id'];
  $level = $_POST['level'];
  $sql = "UPDATE TB_USER_STATUS
 SET USER_LEVEL = '$level'
 WHERE USER_ID LIKE '$id'";
}

$result = mysqli_query($conn, $sql);
$data = array();
while($row = mysqli_fetch_assoc($result)){
  $data[] = $row;
}

echo json_encode($data);

mysqli_close($conn);

?>