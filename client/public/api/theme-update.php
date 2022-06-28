<?php

include("connect.php");
include("axios.php");

if (isset($_POST['contentsListUpdate'])) {
  $sql = "UPDATE TB_CONTENTS
SET `CONTENTS_NAME` = '{$_POST['CONTENTS_NAME']}', `KEYWORD` = '{$_POST['KEYWORD']}',
 `THUMB_PATH` = '{$_POST['THUMB_PATH']}', `CONTENTS_PATH` = '{$_POST['CONTENTS_PATH']}',
 `USE_TYPE` = {$_POST['USE_TYPE']}, `SIZE_CATEGORY_ID` = {$_POST['SIZE_CATEGORY_ID']},
 `SIZE_INFO_ID` = {$_POST['SIZE_INFO_ID']}, `PUBLIC_FLAG` = {$_POST['PUBLIC_FLAG']},
 `U_DATE` = CURRENT_TIMESTAMP()
WHERE `SEQ_ID` = {$_POST['contentsListUpdate']}";
}

if (isset($_POST['contentsUseUnused'])) {
  $sql = "UPDATE `TB_CONTENTS`
  SET `PUBLIC_FLAG` = {$_POST['PUBLIC_FLAG']}, `U_DATE` = CURRENT_TIMESTAMP()
  WHERE `SEQ_ID` = {$_POST['contentsUseUnused']}";
}

post($conn, $sql);

echo json_encode($data);

mysqli_close($conn);
