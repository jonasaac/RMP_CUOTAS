<?php
namespace App\Model\Table;

use App\Model\Entity\Numeracion;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Numeraciones Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Licencias
 */
class NumeracionesTable extends Table
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

        $this->entityClass('Numeracion');
        $this->table('numeraciones');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Licencias', [
            'foreignKey' => 'licencia_id',
            'joinType' => 'INNER',
            'propertyName' => 'licencia'
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
            ->add('inicio', 'valid', ['rule' => 'numeric'])
            ->requirePresence('inicio', 'create')
            ->notEmpty('inicio');

        $validator
            ->add('fin', 'valid', ['rule' => 'numeric'])
            ->requirePresence('fin', 'create')
            ->notEmpty('fin');

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
        $rules->add($rules->existsIn(['licencia_id'], 'Licencias'));
        return $rules;
    }
}
