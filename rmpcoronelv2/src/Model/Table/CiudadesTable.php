<?php
namespace App\Model\Table;

use App\Model\Entity\Ciudade;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ciudades Model
 */
class CiudadesTable extends Table
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
        $this->entityClass('Ciudad');
        $this->table('ciudades');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->belongsTo('Estados',[
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado',
            'conditions' => ['Estados.paridad' => 1]
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
            ->add('estado', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('estado_id');

        return $validator;
    }
}
