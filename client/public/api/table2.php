<?php

require("connect.php");

$query = $conn->query("SELECT count(SEQ_ID) FROM tb_project");
$totalRecords = $query->fetch_row()[0];

$length = $_GET['length'];
$start = $_GET['start'];
 
$sql = "SELECT SEQ_ID, USER_ID, TITLE, SCALE_CD, WIDTH, HEIGHT, SHARE_URL, 
A_DATE, U_DATE FROM tb_project";

if (isset($_GET['search']) && !empty($_GET['search']['value'])) {
    $search = $_GET['search']['value'];
    $sql .= " WHERE USER_ID LIKE '%$search%' OR TITLE LIKE '%$search%' OR SCALE_CD LIKE '%$search%' OR 
    WIDTH LIKE '%$search%' OR HEIGHT LIKE '%$search%'";
}
 
$sql .= " LIMIT $start, $length";
 
$query = $conn->query($sql);
$result = [];
$i = 1;
while ($row = $query->fetch_assoc()) {
    $result[] = [
      "SEQ_ID"=>$row["SEQ_ID"],
      "USER_ID"=>$row["USER_ID"],
      "TITLE"=>$row["TITLE"],
      "SCALE_CD"=>$row["SCALE_CD"],
      "WIDTH"=>$row["WIDTH"],
      "HEIGHT"=>$row["HEIGHT"],
      "SHARE_URL"=>$row["SHARE_URL"],
      "A_DATE"=>$row["A_DATE"],
      "U_DATE"=>$row["U_DATE"],
      "MEMO"=>"<img class='project_img' src='http://localhost/admin/api/img/editor.png'>",
      "editor"=>"<img class='project_img' src='http://localhost/admin/api/img/editor.png'>",
      "delete"=>"<a href='' data-bs-toggle='modal' data-bs-target='#exampleModal'>
      <img class='project_img' src='http://localhost/admin/api/img/delete.png'></a>"
    ];
}
echo json_encode([
    'draw' => $_GET['draw'],
    'recordsTotal' => $totalRecords,
    'recordsFiltered' => $totalRecords,
    'data' => $result,
]);
?>