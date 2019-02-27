<?php
namespace App\Model\Table;

use App\Model\Entity\DescargaDetallesUnidad;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DescdetUnidades Model
 */
class DescargaDetallesUnidadesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->entityClass('DescargaDetallesUnidad');
        $this->table('descarga_detalles_unidades');
        $this->displayField('unidad_id');
        $this->primaryKey(['descarga_detalle_id', 'unidad_id']);
        $this->belongsTo('DescargaDetalles', [
            'foreignKey' => 'descarga_detalle_id',
            'joinType' => 'INNER',
            'propertyName' => 'descarga_detalle',
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
              ->notEmpty('unidad_id');

        $validator
              ->notEmpty('descarga_detalle_id');

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
        $rules->add($rules->existsIn(['descarga_detalle_id'], 'DescargaDetalles'));
        $rules->add($rules->existsIn(['unidad_id'], 'Unidades'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options) {
      // TODO: Deberia usar la precision de la unidad que se está guardando
        $data['cantidad'] = str_replace(',', '.', str_replace(' ', '', str_replace('.', '', $data['cantidad'])));
        $data['cantidad'] = number_format($data['cantidad'], 3, '.', '');
    }
}
