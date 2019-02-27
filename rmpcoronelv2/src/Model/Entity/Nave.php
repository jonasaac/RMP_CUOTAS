<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Nave Entity.
 */
class Nave extends Entity
{

    protected $_virtual = [
      // 'recursos_list'
    ];

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'id' => false,
        '*' => true,
    ];

    protected function _getRecursosIds()
    {
      $recursos_ids = [];
      if ($this->id) {
          $nave = TableRegistry::get('Naves')->get($this->id, [
              'contain' => ['Recursos']
          ]);

          foreach ($nave->recursos as $r) {
              $recursos_ids[] = $r->id;
          }
      }
      return $recursos_ids;
    }

    protected function _getRecursosList()
    {
      $recursos = [];
      if ($this->id) {
          $nave = TableRegistry::get('Naves')->get($this->id, [
              'contain' => ['Recursos']
          ]);

          foreach ($nave->recursos as $r) {
              $recursos[] = $r->nombre;
          }
      }
      return $recursos;
    }
}
