<?php

if(isset($_POST['SEQ_ID'])){

  $id = $_POST['SEQ_ID'];
  
  include 'model.php';
  
  $model = new Model();
  
  if($model->delete($id)){
    $data = array('result' => 'success');
  }else{
    $data = array('result' => 'error');
  }
  echo json_encode($data);
}


// json파일 생성
// $json = json_encode(($result),JSON_UNESCAPED_UNICODE);
// file_put_contents("project.json",$json);
?>