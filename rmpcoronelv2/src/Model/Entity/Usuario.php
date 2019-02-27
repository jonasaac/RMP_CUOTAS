<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Usuario Entity.
 */
class Usuario extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'uid' => true,
        'nombre' => true,
        'estado_id' => true,
        'grupos' => true,
        'change_log' => true,
    ];
}
