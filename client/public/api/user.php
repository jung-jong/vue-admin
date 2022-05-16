<?php

include("connect.php");

$sql = "SELECT * FROM TB_USER_STATUS";

if (isset($_GET['search']) && !empty($_GET['search'])
    && isset($_GET['id'])) {
  $search = $_GET['search'];
  $sql .= " WHERE USER_ID LIKE '%$search%'";

} else if(isset($_GET['search']) && !empty($_GET['search'])
&& isset($_GET['lisense'])){
  $search = $_GET['search'];
  $sql .= " WHERE LICENSE_TYPE LIKE '%$search%'";

} else if(isset($_GET['search']) && !empty($_GET['search'])
&& isset($_GET['status'])){
  $search = $_GET['search'];
  $sql .= " WHERE USER_STATUS LIKE '%$search%'";

} else if(isset($_GET['search']) && !empty($_GET['search'])
&& isset($_GET['lastWork'])){
  $search = $_GET['search'];
  $sql .= " WHERE LAST_WORK_DATE LIKE '%$search%'";

} else if(isset($_GET['search']) && !empty($_GET['search'])
&& isset($_GET['lastDown'])){
  $search = $_GET['search'];
  $sql .= " WHERE LAST_EDIT_DATE LIKE '%$search%'";

} else if(isset($_GET['search']) && !empty($_GET['search'])
&& isset($_GET['storage'])){
  $search = $_GET['search'];
  $sql .= " WHERE STORAGE_USE LIKE '%$search%'";

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