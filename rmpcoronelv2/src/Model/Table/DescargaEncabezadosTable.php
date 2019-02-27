<?php
namespace App\Model\Table;

use App\Model\Entity\DescargaEncabezado;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

/**
 * DescargaEncabezados Model
 */
class DescargaEncabezadosTable extends Table
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
        $this->table('descarga_encabezados');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Movimientos', [
            'foreignKey' => 'movimiento_id',
            'propertyName' => 'movimiento',
            'conditions' => ['Movimientos.tipo' => '1'] //movimiento de entrada
        ]);
        $this->hasMany('DescargaDetalles', [
            'foreignKey' => 'descarga_encabezado_id',
            'propertyName' => 'descarga_detalles',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('DescargaDetallesCamanchaca', [
          'className' => 'DescargaDetalles',
          'foreignKey' => 'descarga_encabezado_id',
          'propertyName' => 'descarga_detalles',
          'conditions' => ['DescargaDetallesCamanchaca.destinatario_id' => 95],
          'dependent' => true,
          'cascadeCallbacks' => true
        ]);
        $this->belongsTo('Recaladas', [
            'foreignKey' => 'recalada_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado'
        ]);
        $this->belongsTo('TipoDescargas', [
            'foreignKey' => 'tipo_descarga_id',
            'propertyName' => 'tipo_descarga'
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('tipo_descarga_id', 'create')
            ->notEmpty('tipo_descarga_id');

        $validator
            ->requirePresence('recalada_id', 'create')
            ->notEmpty('recalada_id');

        $validator
            ->requirePresence('movimiento_id', 'create')
            ->notEmpty('movimiento_id');

        $validator
            ->requirePresence('codigo_descarga', 'create')
            ->notEmpty('codigo_descarga')
            ->add('codigo_descarga', [
                'unique' => ['rule' => 'validateUnique', 'provider' => 'table']
            ]);

        $validator
            ->requirePresence('termino_desembarque', 'create')
            ->notEmpty('termino_desembarque');

        $validator
            ->requirePresence('inicio_desembarque', 'create')
            ->notEmpty('inicio_desembarque');

        $validator
            ->requirePresence('estado_id', 'create')
            ->notEmpty('estado_id');

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
        $rules->add($rules->existsIn(['estado_id'], 'Estados'));
        $rules->add($rules->existsIn(['movimiento_id'], 'Movimientos'));
        $rules->add($rules->existsIn(['tipo_descarga_id'], 'TipoDescargas'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options)
    {
        $shortMonths = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
        $inicio_desembarque = $data['inicio_desembarque'];
        $termino_desembarque = $data['termino_desembarque'];
        if ($data['tipo_descarga_id'] == 1 && isset($data['fecha_primer_lance']))
          $fecha_primer_lance = $data['fecha_primer_lance'];
        else if ($data['tipo_descarga_id'] == 2)
          $fecha_pesca = $data['fecha_pesca'];

        foreach ($shortMonths as $id => $month) {
            $inicio_desembarque = str_replace($month, $id, $inicio_desembarque);
            $termino_desembarque = str_replace($month, $id, $termino_desembarque);
            if ($data['tipo_descarga_id'] == 1 && isset($data['fecha_primer_lance'])) {
              $fecha_primer_lance = str_replace($month, $id, $fecha_primer_lance);
            } else if ($data['tipo_descarga_id'] == 2) {
              $fecha_pesca = str_replace($month, $id, $fecha_pesca);
            }
        }
        $inicio_desembarque = Time::createFromFormat('d-n-Y H:i', $inicio_desembarque);
        $termino_desembarque = Time::createFromFormat('d-n-Y H:i', $termino_desembarque);
        $data['inicio_desembarque'] = $inicio_desembarque;
        $data['termino_desembarque'] = $termino_desembarque;
        if ($data['tipo_descarga_id'] == 1 && isset($data['fecha_primer_lance'])) {
          $fecha_primer_lance = Time::createFromFormat('d-n-Y H:i', $fecha_primer_lance);
          $data['fecha_primer_lance'] = $fecha_primer_lance;
        } else if ($data['tipo_descarga_id'] == 2) {
          $fecha_pesca = Time::createFromFormat('d-n-Y H:i', $fecha_pesca);
          $data['fecha_pesca'] = $fecha_pesca;
        }
    }
}
