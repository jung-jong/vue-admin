<?php

include("connect.php");

$sql = "SELECT `SEQ_ID` FROM `TB_CONTENTS` ORDER BY `SEQ_ID` DESC LIMIT 1";

$result = mysqli_query($conn, $sql);
$data = array();
while($row = mysqli_fetch_assoc($result)){
  $data[] = $row;
}

echo json_encode($data);

mysqli_close($conn);

?>