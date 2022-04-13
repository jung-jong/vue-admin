<?php
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Credentials", "true");
header('Access-Control-Allow-Headers", "Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers');
header('Access-Control-Allow-Methods:GET,POST,PUT,DELETE,OPTIONS');

$db_host = "localhost:3307";
$db_user = "root";
$db_password="wjdwhdgus1";
$db_name="test";
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$action = "";

if(isset($_GET["action"])){
  $action = $_GET["action"];
}

if($action == 'read'){
  $sql = $conn->query("SELECT * FROM tb_project");
  $tb_project = array();
  while($row = $sql->fetch_assoc()){
    array_push($tb_project, $row);
  }
  $result = $tb_project;
}

if ($action == "delete") {
  $id = $_POST['SEQ_ID'];
  $sql = $conn->query("DELETE FROM `tb_project` WHERE SEQ_ID=$id");
  if($sql){
    $result['message'] = "삭제 성공";
  } else {
    $result['error'] = true;
    $result['messsage'] = "삭제 실패";
  }
}

mysqli_close($conn); 
echo json_encode(($result));
// json파일 생성
// $json = json_encode(($result),JSON_UNESCAPED_UNICODE);
// file_put_contents("project.json",$json);
?>