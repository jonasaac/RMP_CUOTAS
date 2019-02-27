<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Divisione Entity.
 */
class Division extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'estado_id' => true,
    ];
}
