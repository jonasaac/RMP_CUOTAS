<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * FolioDetallesUnidade Entity.
 *
 * @property int $folio_detalle_id
 * @property \App\Model\Entity\FolioDetalle $folio_detalle
 * @property int $unidad_id
 * @property \App\Model\Entity\Unidad $unidade
 * @property float $cantidad
 */
class FolioDetallesUnidad extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'folio_detalle_id' => false,
        'unidad_id' => false,
    ];

    protected function _getCantidadTotal()
    {
      $unidad_id = $this->unidad_id;
      $cantidad_total = TableRegistry::get('FolioDetalles')->find()
      ->select([
        'cantidad_total' => 'SUM(DescargaDetallesUnidades.cantidad)'
      ])
      ->where(['FolioDetalles.id' => $this->folio_detalle_id])
      ->matching('DescargaDetalles.Unidades', function ($q) use ($unidad_id) {
        return $q->where(['Unidades.id' => $unidad_id]);
      });

      return $cantidad_total->toArray()[0]->cantidad_total;
    }
}
