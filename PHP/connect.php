<?php
$db_host = "localhost:3307";
$db_user = "root";
$db_password="wjdwhdgus1";
$db_name="test";
$con = mysqli_connect($db_host, $db_user, $db_password, $db_name) or exit("MariaDB 접속 실패!!");
echo "MariaDB 접속 성공";
mysqli_close($con);
?>