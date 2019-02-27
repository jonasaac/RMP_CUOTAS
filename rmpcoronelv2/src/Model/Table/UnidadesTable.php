<?php
namespace App\Model\Table;

use App\Model\Entity\Unidad;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Unidades Model
 */
class UnidadesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->addBehavior('Activate');
        $this->entityClass('Unidad');
        $this->table('unidades');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado',
            'conditions' => ['paridad' => 1]
        ]);
        $this->belongsToMany('DescargaDetalles', [
            'through' => 'DescargaDetallesUnidades',
            'foreignKey' => 'unidad_id',
            'targetForeignKey' => 'descarga_detalle_id',
            'propertyName' => 'descarga_detalles',
        ]);
        $this->belongsToMany('GuiaDetalles', [
            'through' => 'GuiaDetallesUnidades',
            'foreignKey' => 'unidad_id',
            'targetForeignKey' => 'guia_detalle_id',
            'propertyName' => 'guia_detalles',
        ]);
        $this->belongsToMany('Naves', [
            'through' => 'NavesUnidades',
            'foreignKey' => 'unidad_id',
            'targetForeignKey' => 'nave_id',
            'propertyName' => 'naves',
        ]);
        $this->belongsToMany('Recursos', [
            'joinTable' => 'recursos_unidades',
            'foreignKey' => 'unidad_id',
            'targetForeignKey' => 'recurso_id',
            'propertyName' => 'recursos'
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

        $validator
            ->allowEmpty('abreviacion');

        $validator
            ->add('estado', 'valid', ['rule' => 'numeric'])
            ->notEmpty('estado');

        return $validator;
    }
}
