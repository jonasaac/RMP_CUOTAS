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
class GuiaEncabezadosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'creado' => 'new',
                    'actualizado' => 'always'
                ],
                'Model.lock' => [
                    'cerrado' => 'always'
                ]
            ]
        ]);
        $this->table('guia_encabezados');
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
            'dependent' => true
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('nro_guia', 'create')
            ->notEmpty('nro_guia');

        $validator
            ->requirePresence('origen_id', 'create')
            ->notEmpty('origen_id');

        $validator
            ->requirePresence('destino_id', 'create')
            ->notEmpty('destino_id');

        $validator
            ->requirePresence('movimiento_id', 'create')
            ->notEmpty('movimiento_id');

        $validator
            ->requirePresence('estado_id', 'create')
            ->notEmpty('estado_id');

        $validator
            ->requirePresence('guia_detalles', 'create')
            ->notEmpty('guia_detalles');

        $validator
            ->requirePresence('fecha_salida', 'create')
            ->notEmpty('fecha_salida');

        $validator
            ->allowEmpty('observaciones');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['origen_id'], 'OrigenRecintos'));
        $rules->add($rules->existsIn(['destino_id'], 'DestinoRecintos'));
        $rules->add($rules->existsIn(['chofer_id'], 'Choferes'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options)
    {
        $shortMonths = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
        $fecha_salida = $data['fecha_salida'];
        if (isset($data['fecha_recepcion'])) {
          $fecha_recepcion = $data['fecha_recepcion'];
        }
        foreach ($shortMonths as $id => $month) {
            $fecha_salida = str_replace($month, $id, $fecha_salida);
            if (isset($data['fecha_recepcion'])) {
              $fecha_recepcion = str_replace($month, $id, $fecha_recepcion);
            }
        }
        $fecha_salida = Time::createFromFormat('d-n-Y H:i', $fecha_salida);
        $data['fecha_salida'] = $fecha_salida;
        if (isset($data['fecha_recepcion'])) {
          $fecha_recepcion = Time::createFromFormat('d-n-Y H:i', $fecha_recepcion);
          $data['fecha_recepcion'] = $fecha_recepcion;
        }
    }
}
