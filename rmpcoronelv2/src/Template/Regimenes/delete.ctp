<?php
$this->layout = 'ajax';
echo json_encode([
    'status' => $status,
    'data' => $this->request->data;
]);
?>
