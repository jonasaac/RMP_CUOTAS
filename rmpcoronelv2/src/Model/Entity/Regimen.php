<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Regimene Entity.
 */
class Regimen extends Entity
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
