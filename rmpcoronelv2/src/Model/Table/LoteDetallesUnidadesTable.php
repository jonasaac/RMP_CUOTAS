<?php
namespace App\Model\Table;

use App\Model\Entity\LoteDetallesUnidade;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoteDetallesUnidades Model
 *
 * @property \Cake\ORM\Association\BelongsTo $LoteDetalles
 * @property \Cake\ORM\Association\BelongsTo $Unidades
 */
class LoteDetallesUnidadesTable extends Table
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

        $this->table('lote_detalles_unidades');
        $this->displayField('lote_detalle_id');
        $this->primaryKey(['lote_detalle_id', 'unidad_id']);

        $this->belongsTo('LoteDetalles', [
            'foreignKey' => 'lote_detalle_id',
            'joinType' => 'INNER',
            'propertyName' => 'lote_detalle',
            'dependent' => true
        ]);
        $this->belongsTo('Unidades', [
            'foreignKey' => 'unidad_id',
            'joinType' => 'INNER',
            'propertyName' => 'unidad'
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
            ->add('cantidad', 'valid', ['rule' => 'decimal'])
            ->add('cantidad', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('cantidad');

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
        $rules->add($rules->existsIn(['lote_detalle_id'], 'LoteDetalles'));
        $rules->add($rules->existsIn(['unidad_id'], 'Unidades'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options) {
      // TODO: Deberia usar la precision de la unidad que se está guardando
        $data['cantidad'] = str_replace(',', '.', str_replace(' ', '', str_replace('.', '', $data['cantidad'])));
        $data['cantidad'] = number_format($data['cantidad'], 3, '.', '');
    }
}
