<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Operacione Entity.
 *
 * @property int $id
 * @property int $tipo_operacion_id
 * @property \App\Model\Entity\TipoOperacione $tipo_operacione
 * @property \Cake\I18n\Time $fecha_operacion
 * @property int $licencia_id
 * @property \App\Model\Entity\Licencia $licencia
 * @property \Cake\I18n\Time $fecha_inicio
 * @property \Cake\I18n\Time $fecha_termino
 * @property int $macro_zona_id
 * @property \App\Model\Entity\MacroZona $macro_zona
 * @property int $unidad_id
 * @property \App\Model\Entity\Unidad $unidade
 * @property float $cantidad
 * @property \Cake\I18n\Time $creado
 * @property \Cake\I18n\Time $actualizado
 * @property string $usuario_uid
 */
class Operacion extends Entity
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
