<?php
namespace App\Model\Table;

use App\Model\Entity\ArtePesca;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ArtePesca Model
 */
class ArtePescaTable extends Table
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
        $this->table('arte_pesca');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->belongsTo('Recursos', [
          'foreignKey' => 'recurso_id',
          'propertyName' => 'recurso'
        ]);
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado',
            'conditions' => ['Estados.paridad' => 1]
        ]);
        $this->hasMany('DescargaEncabezados', [
            'foreignKey' => 'arte_pesca_id'
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

        return $validator;
    }
}
