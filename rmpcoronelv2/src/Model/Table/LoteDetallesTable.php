<?php
namespace App\Model\Table;

use App\Model\Entity\LoteDetalle;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoteDetalles Model
 *
 * @property \Cake\ORM\Association\BelongsTo $LoteEncabezados
 * @property \Cake\ORM\Association\BelongsTo $Calibres
 * @property \Cake\ORM\Association\BelongsToMany $Unidades
 */
class LoteDetallesTable extends Table
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

        $this->table('lote_detalles');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('LoteEncabezados', [
            'foreignKey' => 'lote_encabezado_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Calibres', [
            'foreignKey' => 'calibre_id',
            'propertyName' => 'calibre',
            'conditions' => ['Calibres.estado_id' => '1'] // solo activos
        ]);
        $this->belongsToMany('Unidades', [
          'trough' => 'LoteDetallesUnidades',
          'foreignKey' => 'lote_detalle_id',
          'targetForeignKey' => 'unidad_id',
          'propertyName' => 'unidades',
          'dependent' => true,
          'cascadeCallbacks' => true,
          'sort' => ['Unidades.id' => 'DESC']
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
            ->requirePresence('pallet', 'create')
            ->notEmpty('pallet');

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
        $rules->add($rules->existsIn(['lote_encabezado_id'], 'LoteEncabezados'));
        $rules->add($rules->existsIn(['calibre_id'], 'Calibres'));
        $rules->add($rules->existsIn(['unidad_id'], 'Unidades'));
        return $rules;
    }
}
