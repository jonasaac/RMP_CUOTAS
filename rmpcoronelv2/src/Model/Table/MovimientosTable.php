<?php
namespace App\Model\Table;

use App\Model\Entity\Movimiento;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Movimientos Model
 *
 * @property \Cake\ORM\Association\HasMany $DescargaEncabezados
 * @property \Cake\ORM\Association\HasMany $GuiaEncabezados
 */
class MovimientosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('movimientos');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->belongsTo('Estados', [
          'foreignKey' => 'estado_id',
          'propertyName' => 'estado',
          'conditions' => ['Estados.paridad' => 1]
        ]);
        $this->hasMany('DescargaEncabezados', [
            'foreignKey' => 'movimiento_id'
        ]);
        $this->hasMany('GuiaEncabezados', [
            'foreignKey' => 'movimiento_id'
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
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        return $validator;
    }
}
