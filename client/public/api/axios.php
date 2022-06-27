<?php

function get($conn, $sql)
{
  global $data;
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }
}

function post($conn, $sql)
{
  global $data;
  $result = mysqli_query($conn, $sql);
  if ($result == false) {
    error_log(mysqli_error($conn));
    $data = array('DB' => "error");
  } else {
    $data = array('DB' => "success");
  }
}
