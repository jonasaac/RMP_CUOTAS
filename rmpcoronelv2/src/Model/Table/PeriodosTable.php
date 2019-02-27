<?php
namespace App\Model\Table;

use App\Model\Entity\Periodo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

/**
 * Periodos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Decretos
 * @property \Cake\ORM\Association\BelongsTo $MacroZonas
 * @property \Cake\ORM\Association\BelongsToMany $Unidades
 */
class PeriodosTable extends Table
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

        $this->table('periodos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Decretos', [
            'foreignKey' => 'decreto_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('MacroZonas', [
            'foreignKey' => 'macro_zona_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Unidades', [
            'through' => 'PeriodosUnidades',
            'foreignKey' => 'periodo_id',
            'targetForeignKey' => 'unidad_id',
            'propertyName' => 'unidades',
            'dependent' => true,
            'cascadeCallbacks' => true
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
            ->add('fecha_inicio', 'valid', ['rule' => 'date'])
            ->requirePresence('fecha_inicio', 'create')
            ->notEmpty('fecha_inicio');

        $validator
            ->add('fecha_termino', 'valid', ['rule' => 'date'])
            ->requirePresence('fecha_termino', 'create')
            ->notEmpty('fecha_termino');

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
        $rules->add($rules->existsIn(['decreto_id'], 'Decretos'));
        $rules->add($rules->existsIn(['macro_zona_id'], 'MacroZonas'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options)
    {
        $shortMonths = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
        $fecha_inicio = $data['fecha_inicio'];
        foreach ($shortMonths as $id => $month) {
            $fecha_inicio = str_replace($month, $id, $fecha_inicio);
        }
        $fecha_inicio = Time::createFromFormat('d-n-Y', $fecha_inicio);
        $data['fecha_inicio'] = $fecha_inicio;
        $fecha_termino = $data['fecha_termino'];
        foreach ($shortMonths as $id => $month) {
            $fecha_termino = str_replace($month, $id, $fecha_termino);
        }
        $fecha_termino = Time::createFromFormat('d-n-Y', $fecha_termino);
        $data['fecha_termino'] = $fecha_termino;
    }}
