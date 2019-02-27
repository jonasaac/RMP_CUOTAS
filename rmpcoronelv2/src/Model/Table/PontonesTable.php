<?php
namespace App\Model\Table;

use App\Model\Entity\Ponton;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Pontones Model
 */
class PontonesTable extends Table
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
        $this->entityClass('Ponton');
        $this->table('pontones');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->belongsTo('Recintos', [
            'foreignKey' => 'id',
            'joinType' => 'INNER',
            'propertyName' => 'recinto',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->belongsTo('Puertos', [
            'foreignKey' => 'puerto_id',
            'joinType' => 'INNER'
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
            ->requirePresence('estado_id', 'create')
            ->notEmpty('estado_id');

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
        $rules->add($rules->existsIn(['puerto_id'], 'Puertos'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options) {
        $data['recinto']['nombre'] = $data['nombre'];
        $data['recinto']['division_id'] = '1';

        if (!empty($data['id']))
            $data['recinto']['id'] = $data['id'];

        return true;
    }

    public function beforeSave($event, $entity, $options) {
        if ($entity->id) {
            $entity->recinto->set('id', $entity->id);
            //$recinto = TableRegistry::get('Recintos')->get($entity->id);
            //$recinto->set('nombre', $entity->nombre);
            //$entity->set('id', $recinto->id);
            //$entity->set('recinto', $recinto);
            if (TableRegistry::get('Recintos')->save($entity->recinto)) {
                return true;
            } else {
                return false;
            }
        }

        $recinto = is_array($entity->recinto) ? TableRegistry::get('Recintos')->newEntity($entity->recinto) : $entity->recinto;
        if (TableRegistry::get('Recintos')->save($recinto)) {
            $entity->set('id', $recinto->id);
            $entity->set('recinto', $recinto);
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete ($event, $entity, $options)
    {
        $recinto = TableRegistry::get('Recintos')->get($entity->id);
        if (TableRegistry::get('Recintos')->delete($recinto))
            return true;
        else
            return false;
    }
}
