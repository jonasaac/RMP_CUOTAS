<?php
namespace App\Model\Table;

use App\Model\Entity\Marea;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

/**
 * Mareas Model
 */
class MareasTable extends Table
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
        $this->table('mareas');
        $this->displayField('display_name');
        $this->primaryKey('id');
        $this->belongsTo('Capitanes', [
            'className' => 'Auxiliares',
            'foreignKey' => 'capitan_id',
            'propertyName' => 'capitan',
            'joinType' => 'INNER',
            'conditions' => ['Capitanes.capitan' => '1']
        ]);
        $this->belongsTo('Puertos', [
            'foreignKey' => 'puerto_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Recaladas', [
            'foreignKey' => 'marea_id'
        ]);
        $this->hasMany('RecaladasAbiertas', [
            'className' => 'Recaladas',
            'conditions' => ['RecaladasAbiertas.estado_id' => '3'],
            'foreignKey' => 'marea_id',
            'propertyName' => 'recaladas_abiertas'
        ]);
        $this->belongsTo('Naves', [
            'foreignKey' => 'nave_id',
            'joinType' => 'INNER',
            'conditions' => ['Naves.estado_id' => '1']
        ]);
        $this->belongsTo('ArtePesca', [
            'foreignKey' => 'arte_pesca_id',
            'propertyName' => 'arte_pesca',
            'conditions' => ['ArtePesca.estado_id' => 1]
        ]);
        $this->belongsTo('Estados', [
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
            ->requirePresence('fecha_zarpe', 'create')
            ->notEmpty('fecha_zarpe');

        $validator
            ->requirePresence('nave_id', 'create')
            ->notEmpty('nave_id');

        $validator
            ->requirePresence('arte_pesca_id', 'create')
            ->notEmpty('arte_pesca_id');

        $validator
            ->requirePresence('capitan_id', 'create')
            ->notEmpty('capitan_id');

        $validator
            ->requirePresence('puerto_id', 'create')
            ->notEmpty('puerto_id');

        $validator
            ->requirePresence('estado_id', 'create')
            ->notEmpty('estado_id');

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
        $rules->add($rules->existsIn(['capitan_id'], 'Capitanes'));
        $rules->add($rules->existsIn(['puerto_id'], 'Puertos'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options)
    {
        $shortMonths = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
        $time = $data['fecha_zarpe'];
        foreach ($shortMonths as $id => $month) {
            $time = str_replace($month, $id, $time);
        }
        $time = Time::createFromFormat('d-n-Y H:i', $time);
        $data['fecha_zarpe'] = $time;
    }
}
