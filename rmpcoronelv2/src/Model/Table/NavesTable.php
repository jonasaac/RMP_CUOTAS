<?php
namespace App\Model\Table;

use App\Model\Entity\Nave;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Naves Model
 */
class NavesTable extends Table
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
        $this->table('naves');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'joinType' => 'INNER',
            'propertyName' => 'estado',
            'conditions' => ['paridad' => 1]
        ]);
        $this->belongsTo('Regimenes', [
            'foreignKey' => 'regimen_id',
            'joinType' => 'INNER',
            'propertyName' => 'regimen'
        ]);
        $this->belongsTo('Divisiones', [
            'foreignKey' => 'division_id',
            'joinType' => 'INNER',
            'propertyName' => 'division'
        ]);
        $this->belongsToMany('Unidades', [
            'through' => 'NavesUnidades',
            'targetForeignKey' => 'unidad_id',
            'foreignKey' => 'nave_id',
            'propertyName' => 'unidades'
        ]);
        $this->belongsTo('Armadores', [
            'className' => 'Auxiliares',
            'foreignKey' => 'armador_id',
            'propertyName' => 'armador',
            'joinType' => 'INNER',
            'conditions' => ['Armadores.armador' => '1']
        ]);
        $this->belongsTo('Representantes', [
            'className' => 'Auxiliares',
            'foreignKey' => 'representante_id',
            'propertyName' => 'representante',
            'joinType' => 'INNER',
            'conditions' => ['Representantes.representante' => '1']
        ]);
        $this->belongsTo('ZonaOperaciones', [
            'foreignKey' => 'zona_operacion_id',
            'propertyName' => 'zona_operacion'
        ]);
        $this->belongsTo('Capitanes', [
            'className' => 'Auxiliares',
            'foreignKey' => 'capitan_id',
            'propertyName' => 'capitan',
            'conditions' => ['Capitanes.capitan' => '1']
        ]);
        $this->belongsTo('Sindicatos', [
            'className' => 'Auxiliares',
            'foreignKey' => 'sindicato_id',
            'propertyName' => 'sindicato',
            'conditions' => ['Sindicatos.sindicato' => '1']
        ]);
        $this->hasMany('Bodegas', [
            'foreignKey' => 'nave_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->belongsToMany('Recursos', [
            'targetForeignKey' => 'recurso_id',
            'foreignKey' => 'nave_id',
            'joinTable' => 'naves_recursos',
            'propertyName' => 'recursos'
        ]);
        $this->belongsToMany('Areas', [
            'targetForeignKey' => 'area_id',
            'foreignKey' => 'nave_id',
            'joinTable' => 'areas_naves',
            'propertyName' => 'areas'
        ]);
        $this->hasMany('Mareas', [
          'foreignKey' => 'nave_id',
          'propertyName' => 'mareas'
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
            ->add('matricula', [
                'unique' => ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Ya existe una Nave con esa matricula.']
            ])
            ->requirePresence('matricula', 'create')
            ->notEmpty('matricula');

        $validator
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        $validator
            ->requirePresence('regimen_id', 'create')
            ->notEmpty('regimen_id');

        $validator
            ->requirePresence('recursos', 'create')
            ->notEmpty('recursos');

        $validator
            ->allowEmpty('senal_distintiva', function ($context) {
                return empty($context['data']['regimen_id']) || $context['data']['regimen_id'] != 1;
            });

        $validator
            ->allowEmpty('unidades');

        $validator
            ->requirePresence('armador_id', 'create')
            ->notEmpty('armador_id');

        $validator
            ->requirePresence('estado_id', 'create')
            ->notEmpty('estado_id');

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
        $rules->add($rules->existsIn(['armador_id'], 'Armadores'));
        $rules->add($rules->existsIn(['representante_id'], 'Representantes'));
        $rules->add($rules->existsIn(['estado_id'], 'Estados'));
        return $rules;
    }
}
?>
