<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Camione Entity.
 */
class Camion extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'patente' => true,
        'transporte_id' => true,
        'tipo_camion' => true,
        'transporte' => true,
        'estado_id' => true,
        'areas' => true
    ];
}
