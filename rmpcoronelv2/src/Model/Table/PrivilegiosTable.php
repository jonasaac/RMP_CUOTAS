<?php
namespace App\Model\Table;

use App\Model\Entity\Privilegio;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Privilegios Model
 */
class PrivilegiosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('privilegios');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->belongsToMany('Grupos', [
            'foreignKey' => 'privilegio_id',
            'targetForeignKey' => 'grupo_id',
            'joinTable' => 'grupos_privilegios'
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
            ->notEmpty('nombre', 'create');

        return $validator;
    }
}
