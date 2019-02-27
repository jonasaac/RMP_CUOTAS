<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Area Entity.
 *
 * @property int $id
 * @property string $nombre
 * @property int $estado_id
 * @property \App\Model\Entity\Estado $estado
 * @property \App\Model\Entity\Grupo[] $grupos
 * @property \App\Model\Entity\Auxiliar[] $auxiliares
 * @property \App\Model\Entity\Especie[] $especies
 * @property \App\Model\Entity\Movimiento[] $movimientos
 * @property \App\Model\Entity\Nave[] $naves
 * @property \App\Model\Entity\Recinto[] $recintos
 * @property \App\Model\Entity\TipoDescarga[] $tipo_descargas
 */
class Area extends Entity
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
