<?php
$this->layout = 'ajax';
$this->response->type('json');

$json_data = ["draw"            => intval( $draw ),
              "recordsTotal"    => intval( $totaldata ),
              "recordsFiltered" => intval( $totalfiltered ),
              "data"            => $folios];

echo json_encode($json_data);
?>
