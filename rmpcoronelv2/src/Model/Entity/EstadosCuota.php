<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EstadosCuotum Entity.
 *
 * @property int $id
 * @property int $macro_zona_id
 * @property \App\Model\Entity\MacroZona $macro_zona
 * @property \Cake\I18n\Time $fecha_estado
 * @property int $especie_id
 * @property \App\Model\Entity\Especie $especy
 * @property \Cake\I18n\Time $creado
 * @property \Cake\I18n\Time $actualizado
 * @property string $usuario_uid
 * @property \App\Model\Entity\Unidad[] $unidades
 */
class EstadosCuota extends Entity
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
