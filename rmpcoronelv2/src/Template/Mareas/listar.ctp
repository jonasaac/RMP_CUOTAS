<?php
$this->layout = 'ajax';
$this->response->type('json');

$json_data = ["draw"            => intval( $draw ),
              "recordsTotal"    => intval( $totaldata ),
              "recordsFiltered" => intval( $totalfiltered ),
              "data"            => $mareas];

echo json_encode($json_data);
//echo json_encode(['data' => $mareas]);
?>
