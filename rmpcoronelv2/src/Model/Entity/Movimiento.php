<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Movimiento Entity.
 */
class Movimiento extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_virtual = [
        'movimiento'
    ];

    protected $_accessible = [
        'nombre' => true,
        'tipo' => true,
        'descarga_encabezados' => true,
        'guia_encabezados' => true,
        'estado' => true
    ];

    protected function _getMovimiento()
    {
        return $this->id.' - '.$this->nombre;
    }
}
