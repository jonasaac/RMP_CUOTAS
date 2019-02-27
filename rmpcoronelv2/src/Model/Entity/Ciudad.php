<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ciudade Entity.
 */
class Ciudad extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'estado' => true,
        'estado_id' => true,
    ];
}
