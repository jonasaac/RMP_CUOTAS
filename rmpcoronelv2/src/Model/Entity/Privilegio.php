<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Privilegio Entity.
 */
class Privilegio extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
    ];
}
