<?php
namespace App\Model\Table;

use App\Model\Entity\Area;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Areas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Estados
 * @property \Cake\ORM\Association\HasMany $Grupos
 * @property \Cake\ORM\Association\BelongsToMany $Auxiliares
 * @property \Cake\ORM\Association\BelongsToMany $Especies
 * @property \Cake\ORM\Association\BelongsToMany $Movimientos
 * @property \Cake\ORM\Association\BelongsToMany $Naves
 * @property \Cake\ORM\Association\BelongsToMany $Recintos
 * @property \Cake\ORM\Association\BelongsToMany $TipoDescargas
 */
class AreasTable extends Table
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

        $this->table('areas');
        $this->displayField('nombre');
        $this->primaryKey('id');

        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'conditions' => ['Estados.paridad' => 1]
        ]);
        $this->belongsToMany('Recursos', [
            'foreignKey' => 'area_id',
            'targetForeignKey' => 'recurso_id',
            'joinTable' => 'areas_recursos'
        ]);
        $this->hasMany('Grupos', [
            'foreignKey' => 'area_id'
        ]);
        $this->belongsToMany('Auxiliares', [
            'foreignKey' => 'area_id',
            'targetForeignKey' => 'auxiliar_id',
            'joinTable' => 'areas_auxiliares'
        ]);
        $this->belongsToMany('Especies', [
            'foreignKey' => 'area_id',
            'targetForeignKey' => 'especy_id',
            'joinTable' => 'areas_especies'
        ]);
        $this->belongsToMany('Movimientos', [
            'foreignKey' => 'area_id',
            'targetForeignKey' => 'movimiento_id',
            'joinTable' => 'areas_movimientos'
        ]);
        $this->belongsToMany('Naves', [
            'foreignKey' => 'area_id',
            'targetForeignKey' => 'nave_id',
            'joinTable' => 'areas_naves'
        ]);
        $this->belongsToMany('Recintos', [
            'foreignKey' => 'area_id',
            'targetForeignKey' => 'recinto_id',
            'joinTable' => 'areas_recintos'
        ]);
        $this->belongsToMany('TipoDescargas', [
            'foreignKey' => 'area_id',
            'targetForeignKey' => 'tipo_descarga_id',
            'joinTable' => 'areas_tipo_descargas'
        ]);
        $this->belongsToMany('Grupos', [
            'foreignKey' => 'area_id',
            'targetForeignKey' => 'grupo_id',
            'joinTable' => 'areas_grupos'
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['estado_id'], 'Estados'));
        return $rules;
    }
}
