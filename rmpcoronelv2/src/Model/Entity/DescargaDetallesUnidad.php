<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * DescdetUnidade Entity.
 */
class DescargaDetallesUnidad extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_virtual = [
        'cantidad_disponible',
        'cantidad_disponible_folios'
    ];

    protected $_accessible = [
        'unidad_id' => true,
        'descarga_detalle_id' => true,
        'cantidad' => true,
        'descarga_detalle' => true,
        'unidad' => true,
    ];

    protected function _getCantidadDisponible()
    {
      $unidad_id = $this->unidad_id;
      $cantidad_total = $this->cantidad;
      $guia_detalles = TableRegistry::get('GuiaDetalles')->find()
      ->select([
        'cantidad_disponible' => 'ROUND(('.$cantidad_total.' - SUM(GuiaDetallesUnidades.cantidad)), 4)'
      ])
      ->where(['descarga_detalle_id' => $this->descarga_detalle_id])
      ->matching('Unidades', function ($q) use ($unidad_id) {
          return $q->where(['Unidades.id' => $unidad_id]);
      });

      return $guia_detalles->toArray()[0]->cantidad_disponible?floatval($guia_detalles->toArray()[0]->cantidad_disponible):$cantidad_total;//$cantidad_disponible;
    }

    protected function _getCantidadDisponibleFolios()
    {
      $unidad_id = $this->unidad_id;
      $cantidad_total = $this->cantidad;
      $folio_detalles = TableRegistry::get('FolioDetalles')->find()
      ->select([
        'cantidad_disponible' => 'ROUND(('.$cantidad_total.' - SUM(FolioDetallesUnidades.cantidad)), 4)'
      ])
      ->where(['descarga_detalle_id' => $this->descarga_detalle_id])
      ->matching('Unidades', function ($q) use ($unidad_id) {
          return $q->where(['Unidades.id' => $unidad_id]);
      });

      return $folio_detalles->toArray()[0]->cantidad_disponible?floatval($folio_detalles->toArray()[0]->cantidad_disponible):$cantidad_total;//$cantidad_disponible;
    }
}
