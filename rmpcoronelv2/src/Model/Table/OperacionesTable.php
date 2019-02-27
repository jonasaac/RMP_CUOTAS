<?php
namespace App\Model\Table;

use App\Model\Entity\Operacion;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Operaciones Model
 *
 * @property \Cake\ORM\Association\BelongsTo $TipoOperaciones
 * @property \Cake\ORM\Association\BelongsTo $Licencias
 * @property \Cake\ORM\Association\BelongsTo $MacroZonas
 * @property \Cake\ORM\Association\BelongsTo $Unidades
 */
class OperacionesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
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
        $this->entityClass('Operacion');
        $this->table('operaciones');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('TipoOperaciones', [
            'foreignKey' => 'tipo_operacion_id',
            'joinType' => 'INNER',
            'propertyName' => 'tipo_operacion'
        ]);
        $this->belongsTo('Licencias', [
            'foreignKey' => 'licencia_id',
            'joinType' => 'INNER',
            'propertyName' => 'licencia'
        ]);
        $this->belongsTo('MacroZonas', [
            'foreignKey' => 'macro_zona_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Unidades', [
            'foreignKey' => 'unidad_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Auxiliares', [
            'foreignKey' => 'auxiliar_id',
            'joinType' => 'LEFT',
            'propertyName' => 'auxiliar'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->date('fecha_promulgacion')
            ->requirePresence('fecha_promulgacion', 'create')
            ->notEmpty('fecha_promulgacion');

        $validator
            ->date('fecha_inicio')
            ->requirePresence('fecha_inicio', 'create')
            ->notEmpty('fecha_inicio');

        $validator
            ->date('fecha_termino')
            ->requirePresence('fecha_termino', 'create')
            ->notEmpty('fecha_termino');

        $validator
            ->decimal('cantidad')
            ->requirePresence('cantidad', 'create')
            ->notEmpty('cantidad');

        $validator
            ->dateTime('creado')
            ->allowEmpty('creado');

        $validator
            ->dateTime('actualizado')
            ->allowEmpty('actualizado');

        $validator
            ->requirePresence('usuario_uid', 'create')
            ->notEmpty('usuario_uid');

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
        $rules->add($rules->existsIn(['tipo_operacion_id'], 'TipoOperaciones'));
        $rules->add($rules->existsIn(['licencia_id'], 'Licencias'));
        $rules->add($rules->existsIn(['macro_zona_id'], 'MacroZonas'));
        $rules->add($rules->existsIn(['unidad_id'], 'Unidades'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options)
    {
        $shortMonths = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
        if (isset($data['fecha_promulgacion'])) {
          $fecha_promulgacion = $data['fecha_promulgacion'];
          foreach ($shortMonths as $id => $month) {
            $fecha_promulgacion = str_replace($month, $id, $fecha_promulgacion);
          }
          $fecha_promulgacion = Time::createFromFormat('d-n-Y', $fecha_promulgacion);
          $data['fecha_promulgacion'] = $fecha_promulgacion;
        }
        if (isset($data['fecha_inicio'])) {
          $fecha_inicio = $data['fecha_inicio'];
          foreach ($shortMonths as $id => $month) {
              $fecha_inicio = str_replace($month, $id, $fecha_inicio);
          }
          $fecha_inicio = Time::createFromFormat('d-n-Y', $fecha_inicio);
          $data['fecha_inicio'] = $fecha_inicio;
        }
        if (isset($data['fecha_termino'])) {
          $fecha_termino = $data['fecha_termino'];
          foreach ($shortMonths as $id => $month) {
              $fecha_termino = str_replace($month, $id, $fecha_termino);
          }
          $fecha_termino = Time::createFromFormat('d-n-Y', $fecha_termino);
          $data['fecha_termino'] = $fecha_termino;
        }
        $precision = 3;
        if (isset($data['unidad_id'])) {
            $unidad = TableRegistry::get('Unidades')->get($data['unidad_id']);
            $precision = $unidad->precision;
        }
        if (isset($data['cantidad'])) {
          $data['cantidad'] = str_replace(',', '.', str_replace(' ', '', str_replace('.', '', $data['cantidad'])));
          $data['cantidad'] = number_format($data['cantidad'], $precision, '.', '');
        }
    }
}
