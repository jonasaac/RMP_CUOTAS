<?php
namespace App\Model\Table;

use App\Model\Entity\FolioEncabezado;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

/**
 * FolioEncabezados Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Estados
 * @property \Cake\ORM\Association\HasMany $FolioDetalles
 */
class FolioEncabezadosTable extends Table
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
        $this->table('folio_encabezados');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('FolioDetalles', [
            'foreignKey' => 'folio_encabezado_id',
            'propertyName' => 'folio_detalles',
            'dependent' => true,
            'cascadeCallbacks' => true,
            'sort' => ['FolioDetalles.fecha_produccion' => 'ASC']
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
            ->requirePresence('nro_folio', 'create')
            ->notEmpty('nro_folio');

        $validator
            ->requirePresence('fecha_recepcion', 'create')
            ->notEmpty('fecha_recepcion');

        $validator
            ->allowEmpty('observaciones');

        $validator
            ->allowEmpty('creado');

        $validator
            ->allowEmpty('actualizado');

        $validator
            ->allowEmpty('cerrado');

        $validator
            ->allowEmpty('usuario_uid');

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
        $rules->add($rules->existsIn(['estado_id'], 'Estados'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options)
    {
        $shortMonths = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
                        5 => 'May',6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
                        9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
        $fecha_recepcion = $data['fecha_recepcion'];
        foreach ($shortMonths as $id => $month) {
            $fecha_recepcion = str_replace($month, $id, $fecha_recepcion);
        }
        $fecha_recepcion = Time::createFromFormat('d-n-Y H:i', $fecha_recepcion);
        $data['fecha_recepcion'] = $fecha_recepcion;
    }
}
