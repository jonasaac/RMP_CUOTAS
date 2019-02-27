<?php
namespace App\Model\Table;

use App\Model\Entity\Planta;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Plantas Model
 */
class PlantasTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('plantas');
        $this->displayField('nombre');
        $this->primaryKey('id');
        /*$this->belongsTo('Encargados', [
            'className' => 'Auxiliares',
            'foreignKey' => 'encargado_id',
            'conditions' => ['Encargados.encargado' => '1'],
            'joinType' => 'INNER',
            'propertyName' => 'encargado'
           ]);*/
        $this->belongsTo('Recintos', [
            'foreignKey' => 'id',
            'joinType' => 'INNER',
            'propertyName' => 'recinto',
            'dependent' => true
        ]);
        $this->hasMany('GuiaEncabezados', [
          'foreignKey' => 'destino_id',
          'propertyName' => 'guia_encabezados'
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
            ->add('codigo', 'valid', ['rule' => 'numeric'])
            ->requirePresence('codigo', 'create')
            ->notEmpty('codigo');

        $validator
            ->requirePresence('seccion', 'create')
            ->notEmpty('seccion');

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
        //$rules->add($rules->existsIn(['encargado_id'], 'Auxiliares'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options) {
        $data['recinto']['nombre'] = $data['nombre'];
        $data['recinto']['division_id'] = '1';
        if (!empty($data['estado_id']))
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
