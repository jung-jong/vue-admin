<?php

include("connect.php");

$sql = "UPDATE TB_CONTENTS
SET `CONTENTS_NAME` = '{$_POST['CONTENTS_NAME']}', `KEYWORD` = '{$_POST['KEYWORD']}',
`THUMB_PATH` = '{$_POST['THUMB_PATH']}', `CONTENTS_PATH` = '{$_POST['CONTENTS_PATH']}',
`USE_TYPE` = {$_POST['USE_TYPE']}, `SIZE_CATEGORY_ID` = {$_POST['SIZE_CATEGORY_ID']},
`SIZE_INFO_ID` = {$_POST['SIZE_INFO_ID']}, `PUBLIC_FLAG` = {$_POST['PUBLIC_FLAG']},
`U_DATE` = CURRENT_TIMESTAMP()
WHERE `SEQ_ID` = {$_POST['SEQ_ID']}";

$result = mysqli_query($conn, $sql);
if ($result == false) {
  error_log(mysqli_error($conn));
  $data = array('DB' => "error");
} else {
  $data = array('DB' => "success");
}

echo json_encode($data);

mysqli_close($conn);