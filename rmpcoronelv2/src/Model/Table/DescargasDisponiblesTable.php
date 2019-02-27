<?php
namespace App\Model\Table;

use App\Model\Entity\DescargaEncabezado;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

/**
 * DescargaEncabezados Model
 */
class DescargasDisponiblesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('descargas_disponibles');
        $this->entityClass('DescargaEncabezado');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('ArtePesca', [
            'foreignKey' => 'arte_pesca_id',
            'propertyName' => 'arte_pesca',
            'conditions' => ['ArtePesca.estado_id' => 1]
        ]);
        $this->belongsTo('Movimientos', [
            'foreignKey' => 'movimiento_id',
            'propertyName' => 'movimiento',
            'conditions' => ['Movimientos.tipo' => '1'] //movimiento de entrada
        ]);
        $this->hasMany('DescargaDetalles', [
            'foreignKey' => 'descarga_encabezado_id',
            'propertyName' => 'descarga_detalles',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->belongsTo('Recaladas', [
            'foreignKey' => 'recalada_id',
        ]);
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'propertyName' => 'estado'
        ]);
        $this->belongsTo('TipoDescargas', [
            'foreignKey' => 'tipo_descarga_id',
            'propertyName' => 'tipo_descarga'
        ]);
    }
}
