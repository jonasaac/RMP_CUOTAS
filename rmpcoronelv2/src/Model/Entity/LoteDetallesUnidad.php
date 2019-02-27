<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LoteDetallesUnidade Entity.
 *
 * @property int $lote_detalle_id
 * @property \App\Model\Entity\LoteDetalle $lote_detalle
 * @property int $unidad_id
 * @property \App\Model\Entity\Unidad $unidad
 * @property float $cantidad
 */
class LoteDetallesUnidad extends Entity
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
        'lote_detalle_id' => false,
        'unidad_id' => false,
        'unidad' => true,
        'cantidad' => true,
    ];
}
