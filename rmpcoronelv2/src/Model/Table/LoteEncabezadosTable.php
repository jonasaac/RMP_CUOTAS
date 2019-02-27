<?php
namespace App\Model\Table;

use App\Model\Entity\LoteEncabezado;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoteEncabezados Model
 *
 * @property \Cake\ORM\Association\BelongsTo $FolioDetalles
 * @property \Cake\ORM\Association\BelongsTo $Estados
 * @property \Cake\ORM\Association\HasMany $LoteDetalles
 */
class LoteEncabezadosTable extends Table
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
        $this->table('lote_encabezados');
        $this->displayField('lote');
        $this->primaryKey('id');

        $this->belongsToMany('FolioDetalles', [
            'joinTable' => 'folio_detalles_lote_encabezados',
            'foreignKey' => 'lote_encabezado_id',
            'targetForeignKey' => 'folio_detalle_id',
            'propertyName' => 'folio_detalles'
        ]);
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado',
            'joinType' => 'INNER',
            'conditions' => ['Estados.paridad' => '2']
        ]);
        $this->hasMany('LoteDetalles', [
            'foreignKey' => 'lote_encabezado_id',
            'propertyName' => 'lote_detalles',
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('lote', 'create')
            ->notEmpty('lote');

        $validator
            ->allowEmpty('sub_codigo');

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
        $rules->add($rules->existsIn(['folio_detalle_id'], 'FolioDetalles'));
        $rules->add($rules->existsIn(['estado_id'], 'Estados'));
        return $rules;
    }
}
