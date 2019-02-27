<?php
namespace App\Model\Table;

use App\Model\Entity\Recalada;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

/**
 * Recaladas Model
 */
class RecaladasTable extends Table
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
        $this->table('recaladas');
        $this->displayField('display_name');
        $this->primaryKey('id');
        $this->belongsTo('Mareas', [
            'foreignKey' => 'marea_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Pontones', [
            'foreignKey' => 'ponton_id',
            'propertyName' => 'ponton'
        ]);
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado'
        ]);
        $this->hasMany('DescargaEncabezados', [
            'foreignKey' => 'recalada_id',
        ]);

        $this->hasMany('DescargasAbiertas', [
            'className' => 'DescargaEncabezados',
            'foreignKey' => 'recalada_id',
            'conditions' => ['DescargasAbiertas.estado_id' => '3'],
            'property_name' => 'descargas_abiertas'
        ]);

        $this->hasMany('DescargasIndustriales', [
            'className' => 'DescargaEncabezados',
            'coditions' => ['DescargasIndustriales.tipo_descarga_id' => '1'],
            'foreignKey' => 'recalada_id',
            'propertyName' => 'descargas_industriales'
        ]);
        $this->hasMany('DescargasArtesanales', [
            'className' => 'DescargaEncabezados',
            'coditions' => ['DescargasArtesanales.tipo_descarga_id' => '2'],
            'foreignKey' => 'recalda_id',
            'propertyName' => 'descargas_artesanales'
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
            ->requirePresence('fecha_recalada', 'create')
            ->notEmpty('fecha_recalada');

        $validator
            ->requirePresence('marea_id', 'create')
            ->notEmpty('marea_id');

        $validator
            ->requirePresence('ponton_id', 'create')
            ->notEmpty('ponton_id');

        $validator
            ->add('nro_recalada', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('nro_recalada', 'create');

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
        $rules->add($rules->existsIn(['marea_id'], 'Mareas'));
        $rules->add($rules->existsIn(['ponton_id'], 'Pontones'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options)
    {
        $shortMonths = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
        $time = $data['fecha_recalada'];
        foreach ($shortMonths as $id => $month) {
            $time = str_replace($month, $id, $time);
        }
        $time = Time::createFromFormat('d-n-Y H:i', $time);
        $data['fecha_recalada'] = $time;
    }
}
