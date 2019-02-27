<?php
namespace App\Model\Table;

use App\Model\Entity\Puerto;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Puertos Model
 */
class PuertosTable extends Table
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
        $this->table('puertos');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->belongsTo('Recintos', [
            'foreignKey' => 'id',
            'joinType' => 'INNER',
            'propertyName' => 'recinto',
            'dependent' => true
        ]);
        $this->hasMany('Mareas', [
            'foreignKey' => 'puerto_id'
        ]);
        $this->hasMany('Pontones', [
            'foreignKey' => 'puerto_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
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
            ->requirePresence('pontones', 'create')
            ->notEmpty('pontones');

        $validator
            ->requirePresence('estado_id', 'create')
            ->notEmpty('estado_id');

        return $validator;
    }

    public function beforeMarshal($event, $data, $options) {
        $data['recinto']['nombre'] = $data['nombre'];
        $data['recinto']['division_id'] = '1';
        $data['recinto']['estado_id'] = $data['estado_id'];

        return true;
    }

    public function beforeSave($event, $entity, $options) {
        if ($entity->id)
            $entity->recinto->set('id', $entity->id);

        if ($recinto = TableRegistry::get('Recintos')->save($entity->recinto)) {
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
