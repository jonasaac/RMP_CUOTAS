<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Auxiliar Entity.
 */
class Auxiliar extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_virtual = [
        //'desc_estado',
        //'full_rut',
        //'funciones',
        'nombre_completo'
    ];

    protected $_accessible = [
        'id' => false,
        '*' => true
    ];

    protected function _getNombreCompleto()
    {
        if ($this->tipo_entidad == 1){
            return $this->nombre.' '.$this->apellido_paterno.' '.$this->apellido_materno;
        } else {
            return $this->nombre_razon_social;
        }
    }

    protected function _getFullRut()
    {
        return str_pad(number_format($this->rut, 0, ',', '.'), '9', '0', STR_PAD_LEFT).'-'.$this->verificador;
    }

    protected function _getDescEstado()
    {
        $estado = TableRegistry::get('Estados')->get($this->estado_id);
        return $estado->id.' - '.$estado->nombre;
    }

    protected function _getFunciones()
    {
        $funciones = ['chofer',
                      'armador',
                      'encargado_planta',
                      'capitan',
                      'destinatario',
                      'representante',
                      'sindicato',
                      'titular_licencia'];
        $afunciones = [];

        foreach($funciones as $funcion) {
            if ($this->$funcion)
                $afunciones[] = $funcion;
        }

        return $afunciones;
    }
}
