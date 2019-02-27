<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Recaladas Controller
 *
 * @property \App\Model\Table\RecaladasTable $Recaladas
 */
class RecaladasController extends AppController
{

    /**
     * Metodo utilizado para verificar el nivel de autorizacion de un usuario
     *
     * @param int|null $user uid de un Usuario a consultar
     * @return bool que indica si el usuario a sido autorizado (true) o no (false)
     */
    public function isAuthorized($user = null)
    {
        if (in_array($this->request->action, ['listar']))
            return true;

        switch ($this->request->action) {
            case 'add': return (bool)in_array('rmp_recalada_add', $this->Auth->user('privilegios')); break;
            case 'edit': return (bool)in_array('rmp_recalada_edit', $this->Auth->user('privilegios')); break;
            case 'delete': return (bool)in_array('rmp_recalada_delete', $this->Auth->user('privilegios')); break;
            case 'lock': return (bool)in_array('rmp_recalada_lock', $this->Auth->user('privilegios')); break;
            case 'unlock': return (bool)in_array('rmp_recalada_unlock', $this->Auth->user('privilegios')); break;
        }
        return parent::isAuthorized($user);
    }

    /**
     * Metodo utilizado para listar las recaladas, que luego serán mostradas
     * en las datatables
     *
     * @param int|null $marea Marea id
     * @param string|null $estado nombre del estado de las recaladas a consultar
     * @return void
     */
    public function listar($marea = null, $estado = 'ABIERTO')
    {
      $recaladas = $this->Recaladas->find('all', [
          'contain' => ['Pontones', 'Pontones.Recintos', 'Estados']
      ])->where(['Estados.nombre' => $estado]);

      if ($marea) {
        $recaladas->where([
            'marea_id' => $marea
        ]);
      }

      $this->set([
        'recaladas'     => $recaladas,
        '_serialize'    => ['recaladas']
      ]);
    }

    /**
     * Add method
     *
     * @return void
     */
    public function add()
    {
      $areasIds = $this->Auth->user('areas_ids');

        $status = 'success';
        $recalada = $this->Recaladas->newEntity();
        if ($this->request->is('post')) {
          $this->request->data['fecha_recalada'] = $this->request->data('fecha_recalada_date').' '.$this->request->data('fecha_recalada_time');
          $recalada = $this->Recaladas->patchEntity($recalada, $this->request->data);
          $recalada->set('estado_id', '3');
          $recalada->set('usuario_uid', $this->Auth->user('uid'));
          if ($this->Recaladas->save($recalada)) {
            $recalada = $this->Recaladas->get($recalada->id, [
              'contain' => ['Pontones.Recintos']
            ]);
            $status = 'success';
          } else {
              $status = 'error';
          }
        }
        /*$pontones = $this->Recaladas->Pontones->find('list', [
            'keyField' => 'id',
            'valueField' => 'desc_name'
        ])
        ->innerJoinWith('Puertos.Recintos.Areas', function ($q) use ($areasIds) {
          return $q->where(['Areas.id IN' => $areasIds]);
        });
        $pontones = $pontones->toArray();
        asort($pontones, SORT_STRING);
        $puertos = $this->Recaladas->Pontones->Puertos->find('all', [
            'contain' => ['Pontones', 'Recintos']
        ])
        ->distinct(['Puertos.id'])
        ->innerJoinWith('Recintos.Areas', function ($q) use ($areasIds) {
          return $q->where(['Areas.id IN' => $areasIds]);
        })
        ->order(['Recintos.nombre' => 'ASC']);*/
        $this->set(compact('recalada', 'status'));
        $this->set('_serialize', ['recalada']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Recalada id.
     * @return void
     */
    public function edit($id = null)
    {
      $areasIds = $this->Auth->user('areas_ids');

        $status = 'success';
        if(isset($this->request->data['id']))
            $id = $this->request->data['id'];

        $recalada = $this->Recaladas->get($id, [
            'contain' => ['Mareas.Naves', 'Pontones']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
          $this->request->data['fecha_recalada'] = $this->request->data('fecha_recalada_date').' '.$this->request->data('fecha_recalada_time');
          $recalada = $this->Recaladas->patchEntity($recalada, $this->request->data);
          $recalada->set('usuario_uid', $this->Auth->user('uid'));
          if ($this->Recaladas->save($recalada)) {
              $status = 'success';
          } else {
              $status = 'error';
          }
        }
        /*$pontones = $this->Recaladas->Pontones->find('list', [
            'keyField' => 'id',
            'valueField' => 'desc_name'
        ]);
        $pontones = $pontones->toArray();
        asort($pontones, SORT_STRING);
        $puertos = $this->Recaladas->Pontones->Puertos->find('all', [
            'contain' => ['Pontones', 'Recintos']
        ])
        ->distinct(['Puertos.id'])
        ->innerJoinWith('Recintos.Areas', function ($q) use ($areasIds) {
          return $q->where(['Areas.id IN' => $areasIds]);
        })
        ->order(['Recintos.nombre' => 'ASC']);*/
        $this->set(compact('recalada', 'status'));
        $this->set('_serialize', ['recalada']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Recalada id.
     * @return void
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $recalada = $this->Recaladas->get($id, ['contain' => 'DescargaEncabezados']);
        if(count($recalada->descarga_encabezados) > 0) {
            $status = 'error';
        } else {
            if ($this->Recaladas->delete($recalada)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }
        $this->set(compact('status'));
    }

    /**
     * Metodo utilizado para manejar el cierre de una recalada
     *
     * @param int|null $id Recalada $id
     * @return void
     **/
    public function lock($id = null) {
        $this->request->allowMethod(['post']);

        $recalada = $this->Recaladas->get($id, ['contain' => ['DescargasAbiertas']]);
        if (count($recalada->descargas_abiertas) > 0) {
            $status = 'error';
        } else {
            $recalada->set('estado_id', '4');
            $this->Recaladas->touch($recalada, 'Model.lock');
            if ($this->Recaladas->save($recalada)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }

        $this->set(compact('status'));
        $this->render('delete');
    }

    /**
     * Metodo utilizado para manejar el re-apertura de una recalada
     *
     * @param int|null $id Recalada $id
     * @return void
     **/
    public function unlock($id = null) {
        $this->request->allowMethod(['post']);

        $recalada = $this->Recaladas->get($id);
        $recalada->set('estado_id', '3');
        if ($this->Recaladas->save($recalada)) {
            $status = 'success';
        } else {
            $status = 'error';
        }

        $this->set(compact('status'));
        $this->render('delete');
    }
}
