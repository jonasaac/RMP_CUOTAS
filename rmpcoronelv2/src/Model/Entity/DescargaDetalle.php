<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * DescargaDetalle Entity.
 */
class DescargaDetalle extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_virtual = [
        //'cantidad_disponible'
    ];

    protected $_accessible = [
        'id' => false,
        '*' => true
    ];

    protected function _getCantidadDisponible()
    {
        $guia_detalles = TableRegistry::get('GuiaDetalles')->find('all', [
            'contain' => 'Unidades'
        ])->where(['descarga_detalle_id' => $this->id]);

        $disponible = [];
        foreach ($this->unidades as $unidad) {
            $disponible[$unidad->nombre] = $unidad->_joinData->cantidad;
        }

        foreach ($guia_detalles as $detalle) {
            foreach ($detalle->unidades as $unidad)
                $disponible[$unidad->nombre] -= $unidad->_joinData->cantidad;
        }

        return $disponible;
    }

    /**
     * Obtiene la cantidad de toneladas para una linea de un
     * documento de descarga.
     * @return [type] [description]
     */
    protected function _getCantidadToneladas()
    {
        $toneladas = 0;
        if (isset($this->id)) {
            foreach ($this->unidades as $unidad) {
                if ($unidad->unidad_id = 1) { // Se seleccionan las toneladas
                    $toneladas += $unidad->_joinData->cantidad;
                }
            }
        }
        return $toneladas;
    }
}
