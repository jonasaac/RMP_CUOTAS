<?php
$this->layout = 'ajax';
header('Content-Type: application/json');
echo json_encode(['data' => $especies]);
?>
