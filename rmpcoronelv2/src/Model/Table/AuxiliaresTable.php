<?php
namespace App\Model\Table;

use App\Model\Entity\Auxiliar;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Auxiliares Model
 */
class AuxiliaresTable extends Table
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
        $this->entityClass('Auxiliar');
        $this->table('auxiliares');
        $this->displayField('nombre_completo');
        $this->primaryKey('id');
        $this->belongsTo('Ciudades', [
            'foreignKey' => 'ciudad_id',
            'joinType' => 'INNER',
            'propertyName' => 'ciudad',
            'conditions' => ['Ciudades.estado_id' => 1]
        ]);
        $this->belongsToMany('Areas', [
            'targetForeignKey' => 'area_id',
            'foreignKey' => 'auxiliar_id',
            'joinTable' => 'areas_auxiliares',
            'propertyName' => 'areas'
        ]);
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'joinType' => 'INNER',
            'conditions' => ['paridad' => 1]
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
            ->notEmpty('tipo_entidad');

        $validator
            ->requirePresence('rut', 'create')
            ->notEmpty('rut')
            ->add('rut',[
                'validFormat' => ['rule' => ['custom', '/^([1-9][0-9]|[1-9])(\.[0-9]{3}){2}\-[0-9kK]{1}$/i'],
                                  'message' => 'El RUT ingresado debe tener un formato valido. p.e: 12.345.678-K'],
                'maxlength' => ['rule' => ['maxLength', 12], 'last' => true],
                'rutvalido' => ['rule' => [$this, 'verificar'],
                             'message' => 'El RUT es invalido, por favor compruebe los datos ingresados.']
            ]);

        $validator
            ->add('verificador', 'valid', ['rule' => 'numeric'])
            ->notEmpty('verificador');

        $validator
            ->requirePresence('domicilio', 'create')
            ->notEmpty('domicilio');

        $validator
            ->requirePresence('ciudad_id', 'create')
            ->notEmpty('ciudad_id');

        $validator
            ->add('estado_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('estado_id', 'create')
            ->notEmpty('estado');

        $validator
            ->allowEmpty('chofer')
            ->allowEmpty('armador')
            ->allowEmpty('encargado_planta')
            ->allowEmpty('capitan')
            ->allowEmpty('destinatario')
            ->allowEmpty('representante')
            ->allowEmpty('auxiliares');

        return $validator;
    }

    public function beforeSave($event, $entity, $options)
    {
        $entity->chofer = (int)$entity->chofer;
        $entity->armador = (int)$entity->armador;
        $entity->encargado_planta = (int)$entity->encargado_planta;
        $entity->capitan = (int)$entity->capitan;
        $entity->destinatario = (int)$entity->destinatario;
        $entity->representante = (int)$entity->representante;
        $entity->transporte = (int)$entity->transporte;
        $entity->tcs = (int)$entity->tcs;

        $tmprut = explode('-', $entity->rut);
        $entity->rut = str_replace('.','',$tmprut[0]);
        $entity->verificador = $tmprut[1];

        return true;
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
        $rules->add($rules->existsIn(['ciudad_id'], 'Ciudades'));
        return $rules;
    }

    public function verificar($value, $context) {
        if (substr($value, -1) == $this->getDigito(substr($value, 0, -2)))
            return true;
        return false;
    }

    protected function limpiarRut($rut)
    {
        $rut = substr($rut, 0,-2);
        $rut = str_replace('.', '', $rut);
        return $rut;
    }

    protected function getDigito($rut)
    {
        $rut = str_replace('.', '', $rut);
        $rutArray = str_split($rut);
        $sum = 0;
        $mul = 2;
        for ($i = count($rutArray) - 1; $i >= 0; $i--) {
            $sum += $rutArray[$i] * $mul;
            $mul++;
            if ($mul > 7 )
                $mul = 2;
        }

        $res = $sum % 11;
        switch ($res) {
            case 1:
                return 'K';
            case 0:
                return 0;
            default:
                return 11 - $res;
        }
        return 1;
    }
}
