<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Licencia Entity.
 *
 * @property int $id
 * @property int $tipo_licencia_id
 * @property \App\Model\Entity\TiposLicencia $tipo_licencia
 * @property int $modifica_licencia_id
 * @property \App\Model\Entity\Licencia $licencia
 * @property string $codigo_resolucion
 * @property \Cake\I18n\Time $fecha_promulgacion
 * @property \Cake\I18n\Time $fecha_inicio_vigencia
 * @property \Cake\I18n\Time $fecha_termino_vigencia
 * @property int $auxiliar_id
 * @property \App\Model\Entity\Auxiliar $auxiliare
 * @property int $especie_id
 * @property \App\Model\Entity\Especie $especy
 * @property int $macro_zona_id
 * @property \App\Model\Entity\MacroZona $macro_zona
 * @property int $estado_id
 * @property \App\Model\Entity\Estado $estado
 * @property string|resource $adjunto
 * @property string $observaciones
 * @property \Cake\I18n\Time $creado
 * @property \Cake\I18n\Time $actualizado
 * @property string $usuario_uid
 */
class Licencia extends Entity
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
    protected $_virtual = [
        'porcentaje', 'display_name'
    ];

    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected function _getPorcentaje()
    {
        $porcentaje = 0.0;
        if (!empty($this->id)) {
          $unidades = TableRegistry::get('LicenciasUnidades')->find('all')
          ->where([
              'LicenciasUnidades.licencia_id' => $this->id,
              'LicenciasUnidades.unidad_id' => 5
          ]);

          if ($unidades->count() > 0 && !empty($unidades->toArray())) {
              $porcentaje = $unidades->toArray()[0]->cantidad;
          }
        }

        return $porcentaje;
    }

    protected function _getUmr()
    {
        $umr = 0;
        if (!empty($this->id)) {
          $unidades = TableRegistry::get('LicenciasUnidades')->find('all')
              ->where([
                  'LicenciasUnidades.licencia_id' => $this->id,
                  'LicenciasUnidades.unidad_id' => 7 // UMR
              ]);

          if ( count($unidades) > 0 && !empty($unidades->toArray())) {
              $umr = $unidades->toArray()[0]->cantidad;
          } else {
              $umr = 0;
          }
        }
        return $umr;
    }

    protected function _getDisplayName()
    {
        $display_name = '';
        if (!empty($this->id)) {
            $tipo_licencia = TableRegistry::get('TiposLicencia')->get($this->tipo_licencia_id);
            $display_name = $tipo_licencia->abreviacion.': '.$this->fecha_promulgacion->format('Y').' - '.$this->codigo_resolucion;
        }
        return $display_name;
    }

    protected function _getIsExpired()
    {
      $result = false;
      if (!empty($this->id)) {
        $result = $this->fecha_termino_vigencia < new \DateTime();
      }
      return $result;
    }

    protected function _getCantidadDisponible()
    {
      if (!empty($this->id)) {
        $result = TableRegistry::get('Cuota', ['table' => 'cuota_disponible_por_resolucion'])
          ->find('all')
          ->where(['Cuota.licencia_id' => $this->id]);
        if ($result->count() > 0) {
          $result = $result->first();
          return $result->total_resolucion - $result->total_captura;
        } else {
          return 0;
        }
      }
      return 0;
    }
}
