<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LoteDetalle Entity.
 *
 * @property int $id
 * @property int $lote_encabezado_id
 * @property \App\Model\Entity\LoteEncabezado $lote_encabezado
 * @property string $pallet
 * @property int $calibre_id
 * @property \App\Model\Entity\Calibre $calibre
 * @property \App\Model\Entity\Unidad[] $unidades
 */
class LoteDetalle extends Entity
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
        'unidades' => true,
        'id' => false,
    ];
}
