<?php
$this->layout = 'ajax';
foreach($naves as $nave) {
    foreach($nave->unidades as $unidad){
        $unidad->_joinData->capacidad = $this->Number->precision($unidad->_joinData->capacidad, 3);
    }
    foreach($nave->bodegas as $bodega){
        $bodega->capacidad = $this->Number->precision($bodega->capacidad, 3);
    }
}
echo json_encode(['data' => $naves]);
?>
