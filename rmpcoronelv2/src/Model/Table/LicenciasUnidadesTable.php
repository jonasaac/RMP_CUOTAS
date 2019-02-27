<?php
namespace App\Model\Table;

use App\Model\Entity\LicenciasUnidad;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * LicenciasUnidades Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Licencias
 * @property \Cake\ORM\Association\BelongsTo $Unidades
 */
class LicenciasUnidadesTable extends Table
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

        $this->entityClass('LicenciasUnidad');
        $this->table('licencias_unidades');
        $this->displayField('licencia_id');
        $this->primaryKey(['licencia_id', 'unidad_id']);

        $this->belongsTo('Licencias', [
            'foreignKey' => 'licencia_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Unidades', [
            'foreignKey' => 'unidad_id',
            'joinType' => 'INNER'
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
            ->add('cantidad', 'valid', ['rule' => 'numeric'])
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
        $rules->add($rules->existsIn(['licencia_id'], 'Licencias'));
        $rules->add($rules->existsIn(['unidad_id'], 'Unidades'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options) {
        $precision = 3;
        if (isset($data['unidad_id'])) {
            $unidad = TableRegistry::get('Unidades')->get($data['unidad_id']);
            $precision = $unidad->precision;
        }
        $data['cantidad'] = str_replace(',', '.', str_replace(' ', '', str_replace('.', '', $data['cantidad'])));
        $data['cantidad'] = number_format($data['cantidad'], $precision, '.', '');
    }
}
