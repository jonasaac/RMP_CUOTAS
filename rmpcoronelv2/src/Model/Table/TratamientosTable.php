<?php
namespace App\Model\Table;

use App\Model\Entity\Tratamiento;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tratamientos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Estados
 * @property \Cake\ORM\Association\HasMany $ControlesCalidad
 */
class TratamientosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->addBehavior('Activate');
        $this->table('tratamientos');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'joinType' => 'INNER',
            'conditions' => ['Estados.paridad' => 1]
        ]);
        $this->hasMany('ControlesCalidad', [
            'foreignKey' => 'tratamiento_id'
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
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

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
        return $rules;
    }
}
