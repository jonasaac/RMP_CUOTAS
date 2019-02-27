<?php
namespace App\Model\Table;

use App\Model\Entity\Calibre;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Calibres Model
 *
 * @property \Cake\ORM\Association\HasMany $Lotes
 */
class CalibresTable extends Table
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

        $this->table('calibres');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->BelongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado',
            'conditions' => ['Estados.paridad' => 1]
        ]);
        $this->hasMany('Lotes', [
            'foreignKey' => 'calibre_id'
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
}
