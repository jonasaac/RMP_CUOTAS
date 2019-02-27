<?php
namespace App\Model\Table;

use App\Model\Entity\GuiaEncabezado;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

/**
 * GuiaEncabezados Model
 */
class GuiasConCalidadTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('guias_con_calidad');
        $this->entityClass('GuiaEncabezado');
        $this->displayField('nro_guia');
        $this->primaryKey('id');
        $this->belongsTo('Divisones', [
            'foreignKey' => 'division_id',
            'joinType' => 'INNER',
            'propertyName' => 'division'
        ]);
        $this->belongsTo('Recursos', [
            'foreignKey' => 'recurso_id',
            'joinType' => 'INNER',
            'propertyName' => 'recurso'
        ]);
        $this->belongsTo('OrigenRecintos', [
            'className' => 'Recintos',
            'foreignKey' => 'origen_id',
            'joinType' => 'INNER',
            'propertyName' => 'origen'
        ]);
        $this->belongsTo('DestinoRecintos', [
            'className' => 'Recintos',
            'foreignKey' => 'destino_id',
            'joinType' => 'INNER',
            'propertyName' => 'destino'
        ]);
        $this->belongsTo('Camiones', [
            'foreignKey' => 'camion_id',
            'propertyName' => 'camion'
        ]);
        $this->belongsTo('Choferes', [
            'className' => 'Auxiliares',
            'foreignKey' => 'chofer_id',
            'propertyName' => 'chofer',
            'conditions' => ['Choferes.chofer' => '1']
        ]);
        $this->hasMany('GuiaDetalles', [
            'foreignKey' => 'guia_encabezado_id',
            'propertyName' => 'guia_detalles',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado',
            'joinType' => 'INNER',
            'conditions' => ['Estados.paridad' => '2']
        ]);
        $this->belongsTo('Movimientos', [
            'foreignKey' => 'movimiento_id',
            'propertyName' => 'movimiento',
            'joinType' => 'INNER',
            'conditions' => ['Movimientos.tipo' => '2']
        ]);
        $this->hasOne('ControlesCalidad', [
            'foreignKey' => 'guia_encabezado_id',
            'propertyName' => 'control_calidad',
            'joinType' => 'INNER',
            'dependent' => true
        ]);
    }
}
