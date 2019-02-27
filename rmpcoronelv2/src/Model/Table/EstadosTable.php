<?php
namespace App\Model\Table;

use App\Model\Entity\Estado;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Estados Model
 *
 * @property \Cake\ORM\Association\HasMany $ArtePesca
 * @property \Cake\ORM\Association\HasMany $Auxiliares
 * @property \Cake\ORM\Association\HasMany $Camiones
 * @property \Cake\ORM\Association\HasMany $Ciudades
 * @property \Cake\ORM\Association\HasMany $DescargaEncabezados
 * @property \Cake\ORM\Association\HasMany $Divisiones
 * @property \Cake\ORM\Association\HasMany $Especies
 * @property \Cake\ORM\Association\HasMany $Grupos
 * @property \Cake\ORM\Association\HasMany $GuiaEncabezados
 * @property \Cake\ORM\Association\HasMany $Mareas
 * @property \Cake\ORM\Association\HasMany $Naves
 * @property \Cake\ORM\Association\HasMany $Recaladas
 * @property \Cake\ORM\Association\HasMany $Recintos
 * @property \Cake\ORM\Association\HasMany $Recursos
 * @property \Cake\ORM\Association\HasMany $Transportes
 * @property \Cake\ORM\Association\HasMany $Tratamientos
 * @property \Cake\ORM\Association\HasMany $Unidades
 * @property \Cake\ORM\Association\HasMany $Usuarios
 */
class EstadosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('estados');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->hasMany('ArtePesca', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Auxiliares', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Camiones', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Ciudades', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('DescargaEncabezados', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Divisiones', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Especies', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Grupos', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('GuiaEncabezados', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Mareas', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Naves', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Recaladas', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Recintos', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Recursos', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Transportes', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Tratamientos', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Unidades', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Usuarios', [
            'foreignKey' => 'estado_id'
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
