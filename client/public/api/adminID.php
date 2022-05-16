<?php

include("connect.php");

$sql = "SELECT * FROM TB_USER_STATUS WHERE USER_LEVEL = '1' OR USER_LEVEL = '2'";

if (isset($_GET['search']) && !empty($_GET['search'])
    && isset($_GET['id'])) {
  $search = $_GET['search'];
  $sql = "SELECT * FROM TB_USER_STATUS WHERE USER_ID LIKE '%$search%' AND NOT USER_LEVEL = '9'";

} 

if (isset($_GET['start'])) {
  $start = $_GET['start'];
  $length = $_GET['length'];
  $sql .= " LIMIT $start, $length";
}

//전체조회
$result = mysqli_query($conn, $sql);
$data = array();
while($row = mysqli_fetch_assoc($result)){
  $data[] = $row;
}

echo json_encode($data);

mysqli_close($conn);

?>