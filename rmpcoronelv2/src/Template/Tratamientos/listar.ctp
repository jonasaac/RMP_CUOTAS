<?php
$this->layout = 'ajax';

echo json_encode([
    'data' => $tratamientos,
]);
?>
