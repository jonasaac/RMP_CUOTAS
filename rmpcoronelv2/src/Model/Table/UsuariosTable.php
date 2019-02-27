<?php
namespace App\Model\Table;

use App\Model\Entity\Usuario;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Usuarios Model
 */
class UsuariosTable extends Table
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
        $this->table('usuarios');
        $this->displayField('uid');
        $this->primaryKey('uid');
        $this->belongsToMany('Grupos', [
            'foreignKey' => 'usuario_uid',
            'targetForeignKey' => 'grupo_id',
            'joinTable' => 'grupos_usuarios'
        ]);
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado',
            'conditions' => ['paridad' => '1']
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
            ->requirePresence('uid', 'create')
            ->notEmpty('uid', 'create');

        $validator
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        $validator
            ->requirePresence('estado_id', 'create')
            ->notEmpty('estado_id');

        return $validator;
    }
}
