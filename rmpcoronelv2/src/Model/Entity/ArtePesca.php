<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ArtePesca Entity.
 */
class ArtePesca extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'estado_id' => true,
        'recurso_id' => true,
        'estado' => true,
        'descarga_encabezados' => true,
    ];
}
