<?php
namespace App\Model\Table;

use App\Model\Entity\FolioDetallesUnidade;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FolioDetallesUnidades Model
 *
 * @property \Cake\ORM\Association\BelongsTo $FolioDetalles
 * @property \Cake\ORM\Association\BelongsTo $Unidades
 */
class FolioDetallesUnidadesTable extends Table
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

        $this->entityClass('FolioDetallesUnidad');
        $this->table('folio_detalles_unidades');
        $this->displayField('folio_detalle_id');
        $this->primaryKey(['folio_detalle_id', 'unidad_id']);

        $this->belongsTo('FolioDetalles', [
            'foreignKey' => 'folio_detalle_id',
            'joinType' => 'INNER',
            'propertyName' => 'folio_detalle',
            'dependent' => true,
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
            ->requirePresence('cantidad', 'create')
            ->notEmpty('cantidad');

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
        $rules->add($rules->existsIn(['unidad_id'], 'Unidades'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options) {
      // TODO: Deberia usar la precision de la unidad que se está guardando
        $data['cantidad'] = str_replace(',', '.', str_replace(' ', '', str_replace('.', '', $data['cantidad'])));
        $data['cantidad'] = number_format($data['cantidad'], 3, '.', '');
    }
}
