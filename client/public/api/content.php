<?php
include("connect.php");

$sql = "SELECT * FROM tb_contents";

if (isset($_GET['search']) && !empty($_GET['search'])
    && isset($_GET['name'])) {
  $search = $_GET['search'];
  $sql .= " WHERE NAME LIKE '%$search%'";

} else if(isset($_GET['search']) && !empty($_GET['search'])
&& isset($_GET['type'])){
  $search = $_GET['search'];
  $sql .= " WHERE TYPE LIKE '%$search%'";
  
} else if(isset($_GET['search']) && !empty($_GET['search'])
&& isset($_GET['tag'])){
  $search = $_GET['search'];
  $sql .= " WHERE TAGS LIKE '%$search%'";
  
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