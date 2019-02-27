<?php
namespace App\Model\Table;

use App\Model\Entity\ControlesCalidad;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControlesCalidad Model
 *
 * @property \Cake\ORM\Association\BelongsTo $GuiaEncabezados
 * @property \Cake\ORM\Association\BelongsTo $Tratamientos
 */
class ControlesCalidadTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'creado' => 'new',
                    'actualizado' => 'always'
                ],
                'Model.lock' => [
                    'cerrado' => 'always'
                ]
            ]
        ]);
        $this->table('controles_calidad');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('GuiaEncabezados', [
            'foreignKey' => 'guia_encabezado_id'
        ]);
        $this->belongsTo('Tratamientos', [
            'foreignKey' => 'tratamiento_id'
        ]);
        $this->BelongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado',
            'conditions' => ['Estados.paridad' => '2']
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
            ->allowEmpty('tvn');

        $validator
            ->allowEmpty('agua');

        $validator
            ->allowEmpty('ph');

        $validator
            ->allowEmpty('c');

        $validator
            ->allowEmpty('n_litro');

        $validator
            ->allowEmpty('talla');

        $validator
            ->allowEmpty('peso');

        $validator
            ->allowEmpty('moda');

        $validator
            ->allowEmpty('cms');

        $validator
            ->allowEmpty('observaciones');

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
        $rules->add($rules->existsIn(['tratamiento_id'], 'Tratamientos'));
        return $rules;
    }
    public function beforeMarshal($event, $data, $options) {
        $data['agua'] = str_replace(',', '.', str_replace(' ', '', str_replace('.', '', $data['agua'])));
        $data['agua'] = number_format($data['agua'], 3);
    }
}
