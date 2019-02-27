<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Pontone Entity.
 */
class Ponton extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */

    protected $_accessible = [
        'puerto_id' => true,
        'puerto' => true,
        'recinto' => true,
    ];

    protected function _getDescName()
    {
        if($this->id) {
            $puerto = TableRegistry::get('Puertos')->get($this->puerto_id);
            return $puerto->nombre. ' - ' .$this->nombre;
        } else {
            return null;
        }
    }

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
