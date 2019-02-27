<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tratamiento Entity.
 */
class Tratamiento extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'estado_id' => true,
        'estado' => true,
        'controles_calidad' => true,
    ];
}
