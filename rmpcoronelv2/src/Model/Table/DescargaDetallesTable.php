<?php
namespace App\Model\Table;

use App\Model\Entity\DescargaDetalle;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DescargaDetalles Model
 */
class DescargaDetallesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('descarga_detalles');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('DescargaEncabezados', [
            'foreignKey' => 'descarga_encabezado_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Especies', [
            'foreignKey' => 'especie_id',
            'propertyName' => 'especie',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ZonasPesca', [
            'foreignKey' => 'zona_pesca_id',
            'propertyName' => 'zona_pesca_o',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Destinatarios', [
            'className' => 'Auxiliares',
            'foreignKey' => 'destinatario_id',
            'propertyName' => 'destinatario',
            'joinType' => 'INNER',
            'conditions' => ['Destinatarios.destinatario' => '1']
        ]);
        $this->belongsTo('TCSs', [
            'className' => 'Auxiliares',
            'foreignKey' => 'tcs_id',
            'propertyName' => 'tcs',
            'joinType' => 'INNER',
            'conditions' => ['TCSs.tcs' => '1']
        ]);
        $this->belongsTo('Licencias', [
            'foreignKey' => 'resolucion_id',
            'propertyName' => 'resolucion_o', // temporal mientras se una el valor string de resolucion
            'joinType' => 'LEFT'
        ]);
        $this->belongsToMany('Unidades', [
            'through' => 'DescargaDetallesUnidades',
            'foreignKey' => 'descarga_detalle_id',
            'targetForeignKey' => 'unidad_id',
            'propertyName' => 'unidades',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('GuiaDetalles', [
            'foreignKey' => 'descarga_detalle_id'
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
            ->requirePresence('especie_id', 'create')
            ->notEmpty('especie_id');

        $validator
            ->requirePresence('destinatario_id', 'create')
            ->notEmpty('destinatario_id');

        $validator
            ->requirePresence('unidades', 'create')
            ->notEmpty('unidades');

        /*$validator
            ->add('zona_pesca_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('zona_pesca_id', 'create')
            ->notEmpty('zona_pesca');

        $validator
            ->add('resolucion_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('resolucion_id', 'create')
            ->notEmpty('resolucion');*/

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
        $rules->add($rules->existsIn(['descarga_encabezado_id'], 'DescargaEncabezados'));
        $rules->add($rules->existsIn(['especie_id'], 'Especies'));
        $rules->add($rules->existsIn(['unidad_id'], 'Unidades'));
        $rules->add($rules->existsIn(['destinatario_id'], 'Destinatarios'));
        return $rules;
    }
}
