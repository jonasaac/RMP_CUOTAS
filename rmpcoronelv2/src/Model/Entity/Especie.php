<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Especy Entity.
 */
class Especie extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'estado_id' => true,
        'recursos' => true,
        'ltp' => true
    ];
}
