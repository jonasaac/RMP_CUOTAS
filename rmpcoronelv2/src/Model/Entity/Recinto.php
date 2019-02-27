<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Recinto Entity.
 */
class Recinto extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'division_id' => true,
        'estado_id' => true,
        'division' => true,
        'estado' => true,
        'puerto' => true,
        'ponton' => true,
        'planta' => true,
        'areas' => true
    ];
}
