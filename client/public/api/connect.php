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
  die("DB 접속 실패: " . mysqli_connect_error());
}
?>