<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Marea Entity.
 */
class Marea extends Entity
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
        'nave_id' => true,
        'fecha_zarpe' => true,
        'capitan_id' => true,
        'puerto_id' => true,
        'arte_pesca_id' => true,
        'estado' => true,
        'observaciones' => true,
        'capitan' => true,
        'puerto' => true,
        'recaladas' => true,
        'nave' => true,
        'recurso_id' => true
    ];

    protected function _getDisplayName()
    {
        $nave = TableRegistry::get('Naves')->get($this->nave_id)->nombre;
        return $this->id.' - '.$nave.' - '.$this->fecha_zarpe;
    }

    protected function _getNroRecaladas()
    {
      if (!empty($this->id)) {
        $recaladas = TableRegistry::get('Recaladas')->find('list')
            ->where(['Recaladas.marea_id' => $this->id]);
        $total = $recaladas->count();

        $abiertas = $recaladas->contain(['Estados'])
            ->where(['Estados.nombre' => 'ABIERTO'])
            ->count();
        return $abiertas.'/'.$total;
      } else {
        return '0/0';
      }
    }
}
