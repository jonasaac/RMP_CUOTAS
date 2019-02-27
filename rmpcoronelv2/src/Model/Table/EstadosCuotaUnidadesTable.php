<?php
namespace App\Model\Table;

use App\Model\Entity\EstadosCuotaUnidad;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * EstadosCuotaUnidades Model
 *
 * @property \Cake\ORM\Association\BelongsTo $EstadosCuota
 * @property \Cake\ORM\Association\BelongsTo $Unidades
 */
class EstadosCuotaUnidadesTable extends Table
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
        $this->entityClass('EstadosCuotaUnidad');

        $this->table('estados_cuota_unidades');
        $this->displayField('estado_cuota_id');
        $this->primaryKey(['estado_cuota_id', 'unidad_id']);

        $this->belongsTo('EstadosCuota', [
            'foreignKey' => 'estado_cuota_id',
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
            ->numeric('cantidad')
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
        $rules->add($rules->existsIn(['estado_cuota_id'], 'EstadosCuota'));
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
