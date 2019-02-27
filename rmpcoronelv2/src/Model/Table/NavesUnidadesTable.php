<?php
namespace App\Model\Table;

use App\Model\Entity\NavesUnidad;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Schema\Table as Schema;

/**
 * NavesUnidades Model
 */
class NavesUnidadesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->entityClass('NavesUnidad');
        $this->table('naves_unidades');
        $this->displayField('unidad_id');
        $this->primaryKey(['unidad_id', 'nave_id']);
        $this->belongsTo('Unidades', [
            'foreignKey' => 'unidad_id',
            'joinType' => 'INNER',
            'propertyName' => 'unidad'
        ]);
        $this->belongsTo('Naves', [
            'foreignKey' => 'nave_id',
            'joinType' => 'INNER',
            'propertyName' => 'nave'
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
     //       ->requirePresence('unidad_id', 'create')
            ->notEmpty('unidad_id');

        $validator
       //     ->requirePresence('nave_id', 'create')
            ->notEmpty('nave_id');

        $validator
            ->requirePresence('capacidad', 'create')
            ->notEmpty('capacidad');

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
        $rules->add($rules->existsIn(['unidad_id'], 'Unidades'));
        $rules->add($rules->existsIn(['nave_id'], 'Naves'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options)
    {
        $data['capacidad'] = str_replace(',', '.', str_replace(' ', '', str_replace('.', '', $data['capacidad'])));
        $data['capacidad'] = number_format($data['capacidad'], 3);
    }
}
