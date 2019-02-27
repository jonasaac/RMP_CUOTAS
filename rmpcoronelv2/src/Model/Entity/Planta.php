<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
/**
 * Planta Entity.
 */
class Planta extends Entity
{

    protected $_virtual = [
      'nombre', 'estado_id', 'division_id'
    ];

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */

    protected $_accessible = [
        'recinto' => true,
        'estado' => true,
        'codigo' => true,
        'seccion' => true,
    ];

        protected function _getNombre()
    {
        if($this->id) {
            $recinto = TableRegistry::get('Recintos')->get($this->id);
            return $recinto->nombre;
        } else {
            return null;
        }
    }

    protected function _getEstadoId()
    {
        if($this->id) {
            $recinto = TableRegistry::get('Recintos')->get($this->id);
            return $recinto->estado_id;
        } else {
            return null;
        }
    }

    protected function _getDivisionId()
    {
        if($this->id) {
            $recinto = TableRegistry::get('Recintos')->get($this->id);
            return $recinto->division_id;
        } else {
            return null;
        }
    }
}
