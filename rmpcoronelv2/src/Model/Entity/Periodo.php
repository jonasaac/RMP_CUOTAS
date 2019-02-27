<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Periodo Entity.
 *
 * @property int $id
 * @property int $decreto_id
 * @property \App\Model\Entity\Decreto $decreto
 * @property \Cake\I18n\Time $fecha_inicio
 * @property \Cake\I18n\Time $fecha_termino
 * @property int $macro_zona_id
 * @property \App\Model\Entity\MacroZona $macro_zona
 * @property \App\Model\Entity\Unidad[] $unidades
 */
class Periodo extends Entity
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
}
