<?php
namespace App\Model\Table;

use App\Model\Entity\MacroZona;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MacroZonas Model
 *
 * @property \Cake\ORM\Association\HasMany $ResolucionDerechos
 * @property \Cake\ORM\Association\BelongsToMany $ZonasPesca
 */
class MacroZonasTable extends Table
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

        $this->table('macro_zonas');
        $this->displayField('nombre');
        $this->primaryKey('id');

        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'property_name' => 'estado',
            'conditions' => ['paridad' => '1']
        ]);
        /*$this->hasMany('Licencias', [
            'foreignKey' => 'macro_zona_id'
        ]);*/
        $this->hasMany('Operaciones', [
            'foreignKey' => 'macro_zona_id',
            'propertyName' => 'operaciones'
        ]);
        $this->belongsToMany('ZonasPesca', [
            'foreignKey' => 'macro_zona_id',
            'targetForeignKey' => 'zona_pesca_id',
            'joinTable' => 'macro_zonas_zonas_pesca'
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
            ->allowEmpty('nombre');

        return $validator;
    }
}
