<?php

include 'model.php';

$model = new Model();

$data = $model->fetchALl();

echo json_encode($data);


?>