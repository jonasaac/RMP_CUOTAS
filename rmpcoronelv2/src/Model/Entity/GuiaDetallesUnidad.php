<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * GuiaDetallesUnidade Entity.
 */
class GuiaDetallesUnidad extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'cantidad' => true,
        'guia_detalle' => true,
        'unidad' => true,
    ];

    protected function _getCantidadTotal()
    {
      $unidad_id = $this->unidad_id;
      $cantidad_total = TableRegistry::get('GuiaDetalles')->find()
      ->select([
        'cantidad_total' => 'SUM(DescargaDetallesUnidades.cantidad)'
      ])
      ->where(['GuiaDetalles.id' => $this->guia_detalle_id])
      ->matching('DescargaDetalles.Unidades', function ($q) use ($unidad_id) {
        return $q->where(['Unidades.id' => $unidad_id]);
      });

      return $cantidad_total->toArray()[0]->cantidad_total;
    }
}
