<?php
namespace App\Model\Table;

use App\Model\Entity\Licencia;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

/**
 * Licencias Model
 *
 * @property \Cake\ORM\Association\BelongsTo $TiposLicencia
 * @property \Cake\ORM\Association\BelongsTo $Licencias
 * @property \Cake\ORM\Association\BelongsTo $Auxiliares
 * @property \Cake\ORM\Association\BelongsTo $Especies
 * @property \Cake\ORM\Association\BelongsTo $MacroZonas
 * @property \Cake\ORM\Association\BelongsTo $Estados
 */
class LicenciasTable extends Table
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
                ]
            ]
        ]);
        $this->table('licencias');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('TiposLicencia', [
            'foreignKey' => 'tipo_licencia_id',
            'joinType' => 'INNER',
            'propertyName' => 'tipo_licencia'
        ]);
        $this->belongsTo('ModificaLicencias', [
            'className' => 'Licencias',
            'foreignKey' => 'modifica_licencia_id',
            'propertyName' => 'modifica_licencia'
        ]);
        $this->belongsTo('Auxiliares', [
            'foreignKey' => 'auxiliar_id',
            'joinType' => 'INNER',
            'propertyName' => 'auxiliar'
        ]);
        $this->belongsTo('Especies', [
            'foreignKey' => 'especie_id',
            'joinType' => 'INNER',
            'propertyName' => 'especie'
        ]);
        $this->belongsToMany('MacroZonas', [
            'foreignKey' => 'licencia_id',
            'targetForeignKey' => 'macro_zona_id',
            'joinTable' => 'licencias_macro_zonas',
            'propertyName' => 'macro_zonas'
        ]);
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Numeraciones', [
            'foreignKey' => 'licencia_id',
            'propertyName' => 'numeraciones',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->belongsToMany('Unidades', [
            'through' => 'LicenciasUnidades',
            'foreignKey' => 'licencia_id',
            'targetForeignKey' => 'unidad_id',
            'propertyName' => 'unidades',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('Operaciones', [
          'foreignKey' => 'licencia_id',
          'propertyName' => 'operaciones',
          'dependent' => true,
          'cascadeCallbacks' => true
        ]);
        $this->belongsTo('Naves', [
            'foreignKey' => 'nave_id',
            'joinType' => 'LEFT',
            'propertyName' => 'nave'
        ]);
        $this->belongsTo('UnidadesCosto', [
            'className' => 'Unidades',
            'foreignKey' => 'costo_unidad_id',
            'joinType' => 'LEFT',
            'propertyName' => 'unidad_costo',
            'conditions' => ['UnidadesCosto.grupo' => 1] // Solo unidades de dinero
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
            ->requirePresence('codigo_resolucion', 'create')
            ->notEmpty('codigo_resolucion');

        $validator
            ->add('fecha_promulgacion', 'valid', ['rule' => 'date'])
            ->requirePresence('fecha_promulgacion', 'create')
            ->notEmpty('fecha_promulgacion');

        $validator
            ->add('fecha_inicio_vigencia', 'valid', ['rule' => 'date'])
            ->requirePresence('fecha_inicio_vigencia', 'create')
            ->notEmpty('fecha_inicio_vigencia');

        $validator
            ->add('fecha_termino_vigencia', 'valid', ['rule' => 'date'])
            ->requirePresence('fecha_termino_vigencia', 'create')
            ->notEmpty('fecha_termino_vigencia');

        $validator
            ->allowEmpty('adjunto');

        $validator
            ->allowEmpty('observaciones');

        $validator
            ->allowEmpty('creado');

        $validator
            ->allowEmpty('actualizado');

        $validator
            ->requirePresence('usuario_uid', 'create')
            ->notEmpty('usuario_uid');

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
        $rules->add($rules->existsIn(['tipo_licencia_id'], 'TiposLicencia'));
        // $rules->add($rules->existsIn(['modifica_licencia_id'], 'Licencias'));
        $rules->add($rules->existsIn(['auxiliar_id'], 'Auxiliares'));
        $rules->add($rules->existsIn(['especie_id'], 'Especies'));
        /*$rules->add($rules->existsIn(['macro_zona_id'], 'MacroZonas'));*/
        $rules->add($rules->existsIn(['estado_id'], 'Estados'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options)
    {
        $shortMonths = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
        $fecha_promulgacion = $data['fecha_promulgacion'];
        foreach ($shortMonths as $id => $month) {
            $fecha_promulgacion = str_replace($month, $id, $fecha_promulgacion);
        }
        $fecha_promulgacion = Time::createFromFormat('d-n-Y', $fecha_promulgacion);
        $data['fecha_promulgacion'] = $fecha_promulgacion;
        $fecha_inicio_vigencia = $data['fecha_inicio_vigencia'];
        foreach ($shortMonths as $id => $month) {
            $fecha_inicio_vigencia = str_replace($month, $id, $fecha_inicio_vigencia);
        }
        $fecha_inicio_vigencia = Time::createFromFormat('d-n-Y', $fecha_inicio_vigencia);
        $data['fecha_inicio_vigencia'] = $fecha_inicio_vigencia;
        $fecha_termino_vigencia = $data['fecha_termino_vigencia'];
        foreach ($shortMonths as $id => $month) {
            $fecha_termino_vigencia = str_replace($month, $id, $fecha_termino_vigencia);
        }
        $fecha_termino_vigencia = Time::createFromFormat('d-n-Y', $fecha_termino_vigencia);
        $data['fecha_termino_vigencia'] = $fecha_termino_vigencia;

        // Se cambia el formato de números
        $data['costo'] = str_replace(',', '.', str_replace(' ', '', str_replace('.', '', $data['costo'])));
        $data['costo'] = number_format($data['costo'], 6);
    }
}
