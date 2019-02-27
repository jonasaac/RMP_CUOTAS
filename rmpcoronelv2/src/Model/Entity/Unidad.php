<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Unidade Entity.
 */
class Unidad extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'id' => false,
        '*' => true
    ];

    protected function _getAbreviacion($abreviacion)
    {
        if($abreviacion === null and isset($this->nombre))
            return substr($this->nombre, 0, 3);
        else
            return $abreviacion;
    }
}
