<?php
namespace App\Model\Table;

use App\Model\Entity\Grupo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Grupos Model
 */
class GruposTable extends Table
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
        $this->table('grupos');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->belongsTo('Divisiones', [
            'foreignKey' => 'division_id',
            'propertyName' => 'division'
        ]);
        $this->belongsToMany('Areas', [
          'foreignKey' => 'grupo_id',
          'targetForeignKey' => 'area_id',
          'joinTable' => 'areas_grupos'
        ]);
        $this->belongsToMany('Usuarios', [
            'foreignKey' => 'grupo_id',
            'targetForeignKey' => 'usuario_uid',
            'joinTable' => 'grupos_usuarios'
        ]);
        $this->belongsToMany('Privilegios', [
            'foreignKey' => 'grupo_id',
            'targetForeignKey' => 'privilegio_id',
            'joinTable' => 'grupos_privilegios',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado',
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        $validator
            ->requirePresence('estado_id', 'create')
            ->notEmpty('estado_id');

        $validator
            ->requirePresence('areas', 'create')
            ->notEmpty('areas');

        $validator
            ->requirePresence('privilegios', 'create')
            ->notEmpty('privilegios');

        return $validator;
    }
}
