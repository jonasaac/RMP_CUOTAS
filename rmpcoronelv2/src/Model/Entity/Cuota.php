<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Marea Entity.
 */
class Cuota extends Entity
{
    protected $_virtual = [
      'nro_recaladas'
    ];

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
