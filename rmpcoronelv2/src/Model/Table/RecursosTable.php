<?php
namespace App\Model\Table;

use App\Model\Entity\Proceso;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Procesos Model
 */
class RecursosTable extends Table
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
        $this->table('recursos');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->belongsToMany('Unidades', [
          'targetForeignKey' => 'unidad_id',
          'foreignKey' => 'recurso_id',
          'joinTable' => 'recursos_unidades',
          'propertyName' => 'unidades'
        ]);
        $this->belongsToMany('Naves', [
            'targetForeignKey' => 'nave_id',
            'foreignKey' => 'recurso_id',
            'joinTable' => 'naves_recursos',
            'propertyName' => 'naves'
        ]);
        $this->belongsToMany('Areas', [
            'targetForeignKey' => 'area_id',
            'foreignKey' => 'recurso_id',
            'joinTable' => 'areas_recursos',
            'propertyName' => 'areas'
        ]);
        $this->belongsToMany('Especies', [
            'targetForeignKey' => 'especie_id',
            'foreignKey' => 'recurso_id',
            'joinTable' => 'especies_recursos',
            'propertyName' => 'especies'
        ]);
        $this->BelongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado',
            'conditions' => ['Estados.paridad' => 1]
        ]);
        $this->BelongsTo('UnidadesPrincipales', [
          'className' => 'Unidades',
          'foreignKey' => 'unidad_principal_id',
          'propertyName' => 'unidad_principal',
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
}
