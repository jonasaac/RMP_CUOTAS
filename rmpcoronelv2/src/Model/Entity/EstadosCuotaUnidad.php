<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EstadosCuotaUnidade Entity.
 *
 * @property int $estado_cuota_id
 * @property \App\Model\Entity\EstadosCuota $estados_cuotum
 * @property int $unidad_id
 * @property \App\Model\Entity\Unidad $unidade
 * @property float $cantidad
 */
class EstadosCuotaUnidad extends Entity
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
        'estado_cuota_id' => false,
        'unidad_id' => false,
    ];
}
