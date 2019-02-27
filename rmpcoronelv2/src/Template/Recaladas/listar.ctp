<?php
$this->layout = 'ajax';
$this->response->header([
  'Content-type: application/json'
  ]);
echo json_encode(['data' => $recaladas]);
?>
