<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * GuiaEncabezado Entity.
 */
class GuiaEncabezado extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_virtual = [
      'total_guia'
    ];

    protected $_accessible = [
        'recurso_id' => true,
        'virtual' => true,
        'movimiento_id' => true,
        'nro_guia' => true,
        'origen_id' => true,
        'destino_id' => true,
        'camion_id' => true,
        'chofer_id' => true,
        'fecha_salida' => true,
        'fecha_recepcion' => true,
        'observaciones' => true,
        'origen' => true,
        'destino' => true,
        'chofer' => true,
        'camion' => true,
        'descargas_guias' => true,
        'guia_detalles' => true,
    ];

    protected function _getTotalGuia ()
    {
      if (!$this->recurso_id) return 0;
      $recurso_id = $this->recurso_id;
      $recurso = TableRegistry::get('Recursos')
                    ->get($recurso_id, ['contain' => [
                      'UnidadesPrincipales'
                    ]]);
      $unidad_principal_id = $recurso->unidad_principal->id;
      $precision = $recurso->unidad_principal->precision;
      $detalles = TableRegistry::get('GuiaDetalles')->find()
                    ->select([
                      'total' => 'SUM(GuiaDetallesUnidades.cantidad)'
                    ])
                    ->where(['GuiaDetalles.guia_encabezado_id' => $this->id])
                    ->matching('Unidades', function ($q) use ($unidad_principal_id) {
                      return $q->where(['Unidades.id' => $unidad_principal_id]);
                    });

      return number_format($detalles->toArray()[0]->total, $recurso->unidad_principal->precision, ',', '').' '.$recurso->unidad_principal->abreviacion;
    }

    protected function _getEstadoCalidad ()
    {
        $estado_calidad = 'SIN CALIDAD';
        $guiaEncabezado = TableRegistry::get('GuiaEncabezados')->find('all')
                                                               ->where(['GuiaEncabezados.id' => $this->id])
                                                               ->matching('ControlesCalidad');

        if ($guiaEncabezado->count() > 0)
            $estado_calidad = 'CONTROLADO';
        return $estado_calidad;
    }
}
