<?php

include("connect.php");
include("axios.php");

$sql = "SELECT AUTO_INCREMENT
FROM information_schema.tables
WHERE table_name = 'TB_CONTENTS'
AND table_schema = DATABASE()";

get($conn, $sql);

echo json_encode($data);

mysqli_close($conn);
