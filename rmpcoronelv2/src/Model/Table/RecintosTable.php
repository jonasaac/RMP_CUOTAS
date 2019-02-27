<?php
namespace App\Model\Table;

use App\Model\Entity\Recinto;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Recintos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Divisiones
 * @property \Cake\ORM\Association\BelongsTo $Estados
 */
class RecintosTable extends Table
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
        $this->table('recintos');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->belongsTo('Divisiones', [
            'foreignKey' => 'division_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Areas', [
            'targetForeignKey' => 'area_id',
            'foreignKey' => 'recinto_id',
            'joinTable' => 'areas_recintos',
            'propertyName' => 'areas',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado',
            'joinType' => 'INNER',
            'conditions' => ['Estados.paridad' => 1]
        ]);
        $this->hasOne('Puertos', [
            'foreignKey' => 'id',
            'propertyName' => 'puerto'
        ]);
        $this->hasOne('Pontones', [
            'foreignKey' => 'id',
            'propertyName' => 'ponton'
        ]);
        $this->hasOne('Plantas', [
            'foreignKey' => 'id',
            'propertyName' => 'planta'
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
        $rules->add($rules->existsIn(['division_id'], 'Divisiones'));
        $rules->add($rules->existsIn(['estado_id'], 'Estados'));
        return $rules;
    }
}
