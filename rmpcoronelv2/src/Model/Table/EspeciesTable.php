<?php
namespace App\Model\Table;

use App\Model\Entity\Especy;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Especies Model
 */
class EspeciesTable extends Table
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
        $this->entityClass('Especie');
        $this->table('especies');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado',
            'conditions' => ['Estados.paridad' => 1]
        ]);
        $this->belongsToMany('Recursos', [
            'foreignKey' => 'especie_id',
            'targetForeignKey' => 'recurso_id',
            'propertyName' => 'recursos',
            'joinTable' => 'especies_recursos',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Licencias', [
            'foreignKey' => 'especie_id',
            'propertyName' => 'licencias'
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

        $validator
            ->add('estado_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('estado_id', 'create')
            ->notEmpty('estado_id');

        $validator
            ->requirePresence('ltp', 'create')
            ->notEmpty('ltp');

        return $validator;
    }
}
