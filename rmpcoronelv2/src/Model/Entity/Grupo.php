<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Grupo Entity.
 */
class Grupo extends Entity
{

    protected $_virtual = [
      'listar_areas'
    ];

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'estado_id' => true,
        'division_id' => true,
        'recurso_id' => true,
        'privilegios' => true,
        'usuarios' => true,
        'areas' => true
    ];

    protected function _getListarAreas()
    {
      if (!empty($this->id)) {
        $grupoId = $this->id;
        $areas = TableRegistry::get('Areas')->find('list')
          ->innerJoinWith('Grupos', function($q) use ($grupoId) {
            return $q->where(['Grupos.id' => $grupoId]);
          })->toArray();

          //debug($areas);

        return array_values($areas);
      } else {
        return '-';
      }
    }

    protected function _getPrivilegiosIds()
    {
        $privilegios_ids = [];
        if ($this->id) {
            $grupo = TableRegistry::get('Grupos')->get($this->id, [
                'contain' => ['Privilegios']
            ]);

            foreach ($grupo->privilegios as $p) {
                $privilegios_ids[] = $p->id;
            }
        }
        return $privilegios_ids;
    }
    /*protected function _getPrivilegios($privilegios)
    {
        $pNombres = [];
        foreach ($privilegios as $privilegio) {
            $pNombres[] = $privilegio->nombre;
        }
        return $pNombres;
    }*/
}
