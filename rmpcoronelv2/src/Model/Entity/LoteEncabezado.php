<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * LoteEncabezado Entity.
 *
 * @property int $id
 * @property int $folio_detalle_id
 * @property \App\Model\Entity\FolioDetalle $folio_detalle
 * @property string $lote
 * @property string $sub_codigo
 * @property string $observaciones
 * @property int $estado_id
 * @property \App\Model\Entity\Estado $estado
 * @property \Cake\I18n\Time $creado
 * @property \Cake\I18n\Time $actualizado
 * @property \Cake\I18n\Time $cerrado
 * @property string $usuario_uid
 * @property \App\Model\Entity\LoteDetalle[] $lote_detalles
 */
class LoteEncabezado extends Entity
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
    protected $_virtual = [
      'calibres', 'kilos_totales', 'cajas_totales'
    ];

    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected function _getFolioDetallesIds()
    {
      $lote_ids = [$this->id];
      if (isset($this->ids)) {
        $lote_ids = explode(',', $this->ids);
      }

      $ids = TableRegistry::get('FolioDetalles')->find('list')
        ->innerJoinWith('LoteEncabezados', function ($q) use ($lote_ids) {
          return $q->where(['LoteEncabezados.id IN' => $lote_ids]);
        });

      return array_keys($ids->toArray());
    }

    protected function _getCalibres()
    {
      $calibres = [];
      $detalles = TableRegistry::get('LoteDetalles')->find('all')
          ->where(['LoteDetalles.lote_encabezado_id' => $this->id])
          ->contain(['Calibres']);

      foreach ($detalles as $detalle) {
        if (!array_key_exists($detalle->calibre_id, $calibres)) {
          $calibres[$detalle->calibre_id] = $detalle->calibre->nombre;
        }
      }
      return array_values($calibres);
    }

    protected function _getKilosTotales()
    {
      $detalles = TableRegistry::get('LoteEncabezados')->find('all')
          ->select([
            'total_kilos' => 'SUM(CASE WHEN Unidades.id = 3 THEN LoteDetallesUnidades.cantidad ELSE 0 END)',
          ])
          ->where(['LoteEncabezados.id' => $this->id])
          ->innerJoinWith('LoteDetalles.Unidades');

      return $detalles->toArray()[0]->total_kilos;
    }

    protected function _getCajasTotales()
    {
      $detalles = TableRegistry::get('LoteEncabezados')->find('all')
          ->select([
            'total_cajas' => 'SUM(CASE WHEN Unidades.id = 4 THEN LoteDetallesUnidades.cantidad ELSE 0 END)',
          ])
          ->where(['LoteEncabezados.id' => $this->id])
          ->innerJoinWith('LoteDetalles.Unidades');

      return $detalles->toArray()[0]->total_cajas;
    }
}
