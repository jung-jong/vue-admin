<?php

include("connect.php");

if (isset($_POST['PUBLIC_FLAG'])) {
  $sql = "UPDATE `TB_CONTENTS`
  SET `PUBLIC_FLAG` = {$_POST['PUBLIC_FLAG']}
  WHERE `SEQ_ID` = {$_POST['SEQ_ID']}";

}
$result = mysqli_query($conn, $sql);
if ($result == false) {
  error_log(mysqli_error($conn));
  $data = array('DB'=>"error");
} else {
  $data = array('DB'=>"success");
}


echo json_encode($data);

mysqli_close($conn);

?>