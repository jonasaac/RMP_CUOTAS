<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NavesUnidade Entity.
 */
class NavesUnidad extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'unidad_id' => true,
        'nave_id' => true,
        'capacidad' => true,
        'unidad' => true,
        'nave' => true,
    ];
}
