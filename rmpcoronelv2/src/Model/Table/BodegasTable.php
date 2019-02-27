<?php
namespace App\Model\Table;

use App\Model\Entity\Bodega;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bodegas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Naves
 */
class BodegasTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('bodegas');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Naves', [
            'foreignKey' => 'nave_id'
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
            ->add('nro', 'valid', ['rule' => 'numeric'])
            ->requirePresence('nro', 'create')
            ->notEmpty('nro');

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
        $rules->add($rules->existsIn(['nave_id'], 'Naves'));
        return $rules;
    }
    public function beforeMarshal($event, $data, $options)
    {
        $data['capacidad'] = str_replace(',', '.', str_replace(' ', '', str_replace('.', '', $data['capacidad'])));
        $data['capacidad'] = number_format($data['capacidad'], 3);
    }
}
