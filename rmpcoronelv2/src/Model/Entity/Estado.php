<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Estado Entity.
 */
class Estado extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_virtual = [
        //'estado'
    ];

    protected $_accessible = [
        'nombre' => true,
        'arte_pesca' => true,
        'auxiliares' => true,
        'camiones' => true,
        'ciudades' => true,
        'descarga_encabezados' => true,
        'divisiones' => true,
        'especies' => true,
        'grupos' => true,
        'guia_encabezados' => true,
        'mareas' => true,
        'naves' => true,
        'recaladas' => true,
        'recintos' => true,
        'recursos' => true,
        'transportes' => true,
        'tratamientos' => true,
        'unidades' => true,
        'usuarios' => true,
    ];

    protected function _getEstado()
    {
        return $this->id.' - '.$this->nombre;
    }
}
