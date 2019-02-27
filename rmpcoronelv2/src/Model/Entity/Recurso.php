<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Proceso Entity.
 */
class Recurso extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'estado_id' => true,
        'especies' => true,
        'unidades' => true,
        'unidad_principal_id' => true
    ];
}
