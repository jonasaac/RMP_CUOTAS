<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Decreto Entity.
 *
 * @property int $id
 * @property string $codigo_resolucion
 * @property \Cake\I18n\Time $fecha_promulgacion
 * @property \Cake\I18n\Time $fecha_inicio_vigencia
 * @property \Cake\I18n\Time $fecha_termino_vigencia
 * @property int $especie_id
 * @property \App\Model\Entity\Especie $especy
 * @property int $estado_id
 * @property \App\Model\Entity\Estado $estado
 * @property string $adjunto
 * @property string $observaciones
 * @property \Cake\I18n\Time $creado
 * @property \Cake\I18n\Time $actualizado
 * @property string $usuario_uid
 * @property \App\Model\Entity\Periodo[] $periodos
 */
class Decreto extends Entity
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
    protected $_virtual = ['total_cuota'];

    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected function _getTotalCuota()
    {
      $total_cuota = 0;
      if (!empty($this->id)) {
        $periodos = TableRegistry::get('Periodos')->find('all', [
          'contain' => ['Unidades']
        ])
        ->matching('Unidades', function($q) {
          return $q->where(['Unidades.id' => '1']);  // TONELADAS
        })
        ->where([
            'Periodos.decreto_id' => $this->id,
        ]);


        if ( count($periodos) > 0 ) {
          foreach ($periodos as $periodo) {
            $total_cuota += $periodo->_matchingData['PeriodosUnidades']->cantidad;
          }
        } else {
          $total_cuota = 0;
        }

      }

      return $total_cuota;
    }

    protected function _getDisplayName()
    {
        $display_name = '';
        if (!empty($this->id)) {
          $display_name = $this->fecha_promulgacion->format('Y').'-'.$this->codigo_resolucion;
        }
        return $display_name;
    }
}
