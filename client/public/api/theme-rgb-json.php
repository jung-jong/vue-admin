<?

$json = json_encode($_POST['rgb']);
$saveDir = ".{$_POST['saveDir']}";
$file = file_put_contents($saveDir, $json);
if (!$file) {
  echo "error";
}
