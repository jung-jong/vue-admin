<?php
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers: x-requested-with');
header('Access-Control-Allow-Methods:GET,POST,PUT,DELETE,OPTIONS');
header("Content-type:text/html;charset=utf-8");

$db_host = "localhost";
$db_user = "nemolabs";
$db_password="!nemolabs2022";
$db_name="tongro";
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$conn) {
  die("DB 접속 실패: " . mysqli_connect_error());
}
mysqli_query($conn, "set session character_set_connection=utf8;");
mysqli_query($conn, "set session character_set_results=utf8;");
mysqli_query($conn, "set session character_set_client=utf8;");

?>