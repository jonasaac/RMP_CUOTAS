<?php
$this->layout = 'ajax';
$this->response->type('json');

//debug($data);
echo json_encode(['data' => $data]);
?>
