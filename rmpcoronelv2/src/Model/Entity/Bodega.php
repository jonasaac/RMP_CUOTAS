<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bodega Entity.
 */
class Bodega extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nave_id' => true,
        'nro' => true,
        'capacidad' => true,
        'nave' => true,
    ];
}
