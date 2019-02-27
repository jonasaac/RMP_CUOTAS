<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transporte Entity.
 */
class Transporte extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'camiones' => true,
    ];
}
