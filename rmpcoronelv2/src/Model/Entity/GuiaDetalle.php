<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GuiaDetalle Entity.
 */
class GuiaDetalle extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'especie_id' => true,
        'descarga_detalle_id' => true,
        'guia_encabezado' => true,
        'especie' => true,
        'unidades' => true,
    ];
}
