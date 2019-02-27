<?php
$finalPontones = [];

foreach ($pontones as $ponton) {
    $finalPontones[] = [
        'id' => $ponton->id,
        'name' => $ponton->display_name,
    ];
}

echo json_encode($finalPontones);
?>
