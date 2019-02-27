<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * FolioEncabezado Entity.
 *
 * @property int $id
 * @property string $nro_folio
 * @property \Cake\I18n\Time $fecha_recepcion
 * @property string $observaciones
 * @property \Cake\I18n\Time $creado
 * @property \Cake\I18n\Time $actualizado
 * @property \Cake\I18n\Time $cerrado
 * @property string $usuario_uid
 * @property int $estado_id
 * @property \App\Model\Entity\FolioDetalle[] $folio_detalles
 */
class FolioEncabezado extends Entity
{

  protected $_virtual = [
    'total_cajas', 'nro_lotes', 'especie'
  ];

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
    'id' => false,
  ];

  protected function _getRendimiento()
  {
    $id = $this->id;
    $total_folio = TableRegistry::get('FolioDetalles')->find('all')
        ->select(['total' => 'SUM(CASE WHEN FolioDetallesUnidades.unidad_id = 1 THEN FolioDetallesUnidades.cantidad ELSE 0 END)'])
        ->matching('Unidades')
        ->where(['FolioDetalles.folio_encabezado_id' => $id])
        ->group(['FolioDetalles.folio_encabezado_id']);

    $total_lotes = TableRegistry::get('LoteEncabezados')->find('all')
        ->select(['total' => 'SUM(CASE WHEN LoteDetallesUnidades.unidad_id = 3 THEN LoteDetallesUnidades.cantidad ELSE 0 END)'])
        ->matching('LoteDetalles.Unidades')
        ->matching('FolioDetalles', function($q) use ($id) {
          return $q->where(['FolioDetalles.folio_encabezado_id' => $id]);
        })
        ->group(['LoteEncabezados.id']);

    if ( !empty($total_folio->toArray()) && !empty($total_lotes->toArray())) {
      $total_folio = $total_folio->toArray()[0]->total;
      $total_lotes = $total_lotes->toArray()[0]->total;
      return (($total_lotes/1000)/$total_folio)*100;
    } else {
      return 0;
    }
  }

  protected function _getTotalCajas()
  {
    $total = 0;
    if (!empty($this->id)) {
    $detalles = TableRegistry::get('FolioDetalles')->find()
        ->select([
          'total_cjs' => 'SUM(FolioDetallesUnidades.cantidad)'
        ])
        ->where([
          'FolioDetalles.folio_encabezado_id' => $this->id
        ])
        ->innerJoinWith('Unidades', function ($q) {
          return $q->where(['Unidades.id' => 2]);
        })->toArray();

        $total = $detalles[0]->total_cjs;
    }
    return number_format($total, 0);
  }

  protected function _getEspecie()
  {
    $especie = '';
    if (!empty($this->id)) {
      $especie = TableRegistry::get('FolioDetalles')->find('all')
          ->where([
            'FolioDetalles.folio_encabezado_id' => $this->id
          ])
          ->contain([
            'Especies'
          ])->first()->especie->nombre;
    }
    return $especie;
  }

  protected function _getNroLotes()
  {
    if (!empty($this->id)) {
      $folioId = $this->id;
      $lotes = TableRegistry::get('LoteEncabezados')->find('list')
          ->innerJoinWith('FolioDetalles.FolioEncabezados', function($q) use ($folioId) {
            return $q->where(['FolioEncabezados.id' => $folioId]);
          });
      $total = count($lotes->toArray());

      $abiertas = count($lotes->contain(['Estados'])
          ->where(['Estados.nombre' => 'ABIERTO'])
          ->toArray());
      return $abiertas.'/'.$total;
    } else {
      return '0/0';
    }
  }
}
