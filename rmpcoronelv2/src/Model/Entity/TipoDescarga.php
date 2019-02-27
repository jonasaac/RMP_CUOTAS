<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TipoDescarga Entity.
 */
class TipoDescarga extends Entity
{

    protected $_virtual = [
      'tipo_descarga'
    ];

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'descarga_encabezados' => true,
        'estado' => true
    ];

    protected function _getTipoDescarga()
    {
        return $this->id.' - '.$this->nombre;
    }
}
