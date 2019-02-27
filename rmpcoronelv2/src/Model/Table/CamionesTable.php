<?php
namespace App\Model\Table;

use App\Model\Entity\Camion;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Camiones Model
 */
class CamionesTable extends Table
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
        $this->entityClass('Camion');
        $this->table('camiones');
        $this->displayField('patente');
        $this->primaryKey('id');
        $this->belongsTo('Transportes', [
          'className' => 'Auxiliares',
          'foreignKey' => 'transporte_id',
          'conditions' => ['Transportes.transporte' => 1],
          'joinType' => 'INNER'
        ]);
        $this->hasMany('GuiaEncabezados', [
            'foreignKey' => 'camion_id'
        ]);
        $this->belongsToMany('Areas', [
            'targetForeignKey' => 'area_id',
            'foreignKey' => 'camion_id',
            'joinTable' => 'areas_camiones',
            'propertyName' => 'areas',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado',
            'joinType' => 'INNER',
            'conditions' => ['Estados.paridad' => '1']
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
            ->allowEmpty('patente', 'create');

        $validator
            ->requirePresence('tipo_camion', 'create')
            ->notEmpty('tipo_camion');

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
        $rules->add($rules->existsIn(['transporte_id'], 'Transportes'));
        return $rules;
    }
}
