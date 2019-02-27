<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Recalada Entity.
 */
class Recalada extends Entity
{

    protected $_virtual = [
      'nro_descargas'
    ];

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'marea_id' => true,
        'ponton_id' => true,
        'fecha_recalada' => true,
        'observaciones' => true,
        'marea' => true,
        'ponton' => true,
        'descargas_industriales' => true,
        'descargas_artesanales' => true,
    ];

    protected function _getDisplayName()
    {
        return $this->nro_recalada.' - '.$this->fecha;
    }

    protected function _getNroDescargas()
    {
      if (!empty($this->id)) {
        $descargas = TableRegistry::get('DescargaEncabezados')->find('list')
            ->where(['DescargaEncabezados.recalada_id' => $this->id]);
        $total = $descargas->count();

        $abiertas = $descargas->contain(['Estados'])
            ->where(['Estados.nombre' => 'ABIERTO'])
            ->count();
        return $abiertas.'/'.$total;
      } else {
        return '0/0';
      }
    }
}
