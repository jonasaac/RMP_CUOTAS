<?php
namespace App\Model\Table;

use App\Model\Entity\FolioDetalle;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

/**
 * FolioDetalles Model
 *
 * @property \Cake\ORM\Association\BelongsTo $FolioEncabezados
 * @property \Cake\ORM\Association\BelongsTo $DescargaDetalles
 * @property \Cake\ORM\Association\BelongsToMany $Unidades
 */
class FolioDetallesTable extends Table
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

        $this->table('folio_detalles');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('FolioEncabezados', [
            'foreignKey' => 'folio_encabezado_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('DescargaDetalles', [
            'foreignKey' => 'descarga_detalle_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Especies', [
            'foreignKey' => 'especie_id',
            'joinType' => 'INNER',
            'propertyName' => 'especie'
        ]);
        $this->belongsToMany('Unidades', [
            'foreignKey' => 'folio_detalle_id',
            'targetForeignKey' => 'unidad_id',
            'joinTable' => 'folio_detalles_unidades',
            'propertyName' => 'unidades',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->belongsToMany('LoteEncabezados', [
          'joinTable' => 'folio_detalles_lote_encabezados',
          'foreignKey' => 'folio_detalle_id',
          'targetForeignKey' => 'lote_encabezado_id',
          'propertyName' => 'lote_encabezados'
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
            ->add('secuencial', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('secuencial');

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
        $rules->add($rules->existsIn(['folio_encabezado_id'], 'FolioEncabezados'));
        $rules->add($rules->existsIn(['descarga_detalle_id'], 'DescargaDetalles'));
        $rules->add($rules->existsIn(['especie_id'], 'Especies'));
        return $rules;
    }

    public function beforeMarshal($event, $data, $options)
    {
        $fecha_produccion = $data['fecha_produccion'];
        /*$shortMonths = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
        foreach ($shortMonths as $id => $month) {
            $fecha_produccion = str_replace($month, $id, $fecha_produccion);
        }
        $fecha_produccion = Time::createFromFormat('d-n-Y', $fecha_produccion);*/
        $data['fecha_produccion'] = explode('T', $fecha_produccion)[0];
    }
}
