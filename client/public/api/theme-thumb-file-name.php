<?php

include("connect.php");

$sql = "SELECT AUTO_INCREMENT
FROM information_schema.tables
WHERE table_name = 'TB_CONTENTS'
AND table_schema = DATABASE()";

$result = mysqli_query($conn, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

echo json_encode($data);

mysqli_close($conn);
