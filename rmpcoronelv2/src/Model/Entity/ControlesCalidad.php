<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ControlesCalidad Entity.
 */
class ControlesCalidad extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'guia_encabezado_id' => true,
        'tratamiento_id' => true,
        'tvn' => true,
        'agua' => true,
        'ph' => true,
        'c' => true,
        'n_litro' => true,
        'talla' => true,
        'peso' => true,
        'moda' => true,
        'cms' => true,
        'observaciones' => true,
        'guia_encabezado' => true,
        'tratamiento' => true,      
        'usuario_uid' => true
    ];
}
