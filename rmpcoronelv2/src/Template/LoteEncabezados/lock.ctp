<?php
$this->layout = 'ajax';

echo json_encode([
    'status' => $status,
    'data' => $loteEncabezado
]);
?>
