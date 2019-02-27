<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * FolioDetalle Entity.
 *
 * @property int $id
 * @property int $folio_encabezado_id
 * @property \App\Model\Entity\FolioEncabezado $folio_encabezado
 * @property int $descarga_detalle_id
 * @property \App\Model\Entity\DescargaDetalle $descarga_detalle
 * @property \App\Model\Entity\Especie $especie
 * @property int $especie_id
 * @property int $secuencial
 * @property \App\Model\Entity\Unidad[] $unidades
 */
class FolioDetalle extends Entity
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
        'id' => false,
    ];

    protected function _getDescripcion()
    {
      if (!empty($this->id)) {
        $especie = TableRegistry::get('Especies')->get($this->especie_id)->nombre;
        $folioDetalle = TableRegistry::get('FolioDetalles')->get($this->id, ['contain' => 'Unidades']);
        $cajas = 0;
        foreach($folioDetalle->unidades as $unidad) {
          if ($unidad->id = 2) {
            $cajas = $unidad->_joinData->cantidad;
          }
        }
        return convertirFecha($this->fecha_produccion->toUnixString(), false).' - '.$especie.' - '.$cajas.' CJS';
      } else {
        return null;
      }
    }
}
