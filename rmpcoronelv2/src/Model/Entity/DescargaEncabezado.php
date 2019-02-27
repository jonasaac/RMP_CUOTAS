<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * DescargaEncabezado Entity.
 */
class DescargaEncabezado extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
      'id' => false,
      '*' => true,  // Permiso a todas los atributos
      /*
        'tipo_descarga' => true,
        'tipo_descarga_id' => true,
        'movimiento_id' => true,
        'movimiento' => true,
        'recalada_id' => true,
        'arte_pesca_id' => true,
        'arte_pesca' => true,
        'inicio_desembarque' => true,
        'termino_desembarque' => true,
        'fecha_pesca' => true,
        'estado_id' => true,
        'estado' => true,
        'observaciones' => true,
        'codigo_descarga' => true,
        'arte_pesca' => true,
        'descarga_detalles' => true,
        'descargas_guias' => true,
        'sin_pesca' => true,
        'recalada' => true,
        */
    ];

    protected function _getGuiasAbiertas()
    {
        $descargaDetalles = TableRegistry::get('DescargaDetalles')->find('all', [
            'contain' => ['GuiaDetalles', 'GuiaDetalles.GuiaEncabezados']
        ])
                                                                  ->where(['DescargaDetalles.descarga_encabezado_id' => $this->id])->matching('GuiaDetalles.GuiaEncabezados', function ($q) {
                                                                      return $q->where(['GuiaEncabezados.estado_id' => '3']);
                                                                  });

        return (bool)$descargaDetalles->count();
    }
}
