<?php
namespace App\Model\Table;

use App\Model\Entity\GuiaDetalle;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GuiaDetalles Model
 */
class GuiaDetallesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('guia_detalles');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('GuiaEncabezados', [
            'foreignKey' => 'guia_encabezado_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('DescargaDetalles', [
            'foreignKey' => 'descarga_detalle_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Especies', [
            'foreignKey' => 'especie_id',
            'propertyName' => 'especie',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Unidades', [
            'trough' => 'GuiaDetallesUnidades',
            'foreignKey' => 'guia_detalle_id',
            'targetForeignKey' => 'unidad_id',
            'propertyName' => 'unidades',
            'dependent' => true,
            'cascadeCallbacks' => true
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
            ->requirePresence('especie_id', 'create')
            ->notEmpty('especie_id');

        $validator
            ->requirePresence('descarga_detalle_id', 'create')
            ->notEmpty('descarga_detalle_id');

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
        $rules->add($rules->existsIn(['guia_encabezado_id'], 'GuiaEncabezados'));
        $rules->add($rules->existsIn(['especie_id'], 'Especies'));
        $rules->add($rules->existsIn(['unidad_id'], 'Unidades'));
        return $rules;
    }
}
