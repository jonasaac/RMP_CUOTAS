<?php
namespace App\Model\Table;

use App\Model\Entity\EstadosCuota;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

/**
 * EstadosCuota Model
 *
 * @property \Cake\ORM\Association\BelongsTo $MacroZonas
 * @property \Cake\ORM\Association\BelongsTo $Especies
 * @property \Cake\ORM\Association\BelongsToMany $Unidades
 */
class EstadosCuotaTable extends Table
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
                ]
            ]
        ]);
        $this->entityClass('EstadosCuota');

        $this->table('estados_cuota');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('MacroZonas', [
            'foreignKey' => 'macro_zona_id',
            'joinType' => 'INNER',
            'propertyName' => 'macro_zona'
        ]);
        $this->belongsTo('Especies', [
            'foreignKey' => 'especie_id',
            'joinType' => 'INNER',
            'propertyName' => 'especie'
        ]);
        $this->belongsToMany('Unidades', [
            'through' => 'EstadosCuotaUnidades',
            'foreignKey' => 'estado_cuota_id',
            'targetForeignKey' => 'unidad_id',
            'joinTable' => 'estados_cuota_unidades',
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->date('fecha_estado')
            ->requirePresence('fecha_estado', 'create')
            ->notEmpty('fecha_estado');

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
        $rules->add($rules->existsIn(['macro_zona_id'], 'MacroZonas'));
        $rules->add($rules->existsIn(['especie_id'], 'Especies'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options)
    {
        $shortMonths = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
        $fecha_estado = $data['fecha_estado'];
        foreach ($shortMonths as $id => $month) {
            $fecha_estado = str_replace($month, $id, $fecha_estado);
        }
        $fecha_estado = Time::createFromFormat('d-n-Y', $fecha_estado);
        $data['fecha_estado'] = $fecha_estado;
    }

}
