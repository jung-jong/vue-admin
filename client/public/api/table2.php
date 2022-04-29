<?php

require("connect.php");

$query = $conn->query("SELECT count(SEQ_ID) FROM TB_PROJECT");
$totalRecords = $query->fetch_row()[0];

$length = $_GET['length'];
$start = $_GET['start'];
 
$sql = "SELECT * FROM TB_PROJECT";

if (isset($_GET['search']) && !empty($_GET['search']['value'])) {
    $search = $_GET['search']['value'];
    $sql .= "WHERE USER_ID LIKE '%$search%' OR TITLE LIKE '%$search%' OR SCALE_CD LIKE '%$search%' OR 
    WIDTH LIKE '%$search%' OR HEIGHT LIKE '%$search%' OR SHARE_URL LIKE '%$search%'
    OR A_DATE LIKE '%$search%' OR U_DATE LIKE '%$search%'";
}
 
$sql .= "LIMIT $start, $length";
 
$query = $conn->query($sql);
$result = [];
while ($row = $query->fetch_assoc()) {
    $result[] = [
      $row["SEQ_ID"],
      $row["USER_ID"],
      $row["TITLE"],
      $row["SCALE_CD"],
      $row["WIDTH"],
      $row["HEIGHT"],
      $row["SHARE_URL"],
      $row["A_DATE"],
      $row["U_DATE"],
    ];
}
echo json_encode([
    'draw' => $_GET['draw'],
    'recordsTotal' => $totalRecords,
    'recordsFiltered' => $totalRecords,
    'data' => $result,
]);


?>