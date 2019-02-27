<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Controller para Grupos
 *
 * @property \App\Model\Table\GruposTable $Grupos
 */
class GruposController extends AppController
{
  /**
   * Metodo utilizado para verificar si un usuario está autorizado a acceder
   * a un modulo o no
   *
   * @param string|null $user con el nombre del usuario a consultar
   * @return bool true si está autorizado false en otro caso.
   **/
  public function isAuthorized($user = null) {
    // Privilegios por acción
    $tmp_permiso = false;
    switch ($this->request->action) {
        case 'index':
        case 'listar':
        $search = 'admin_usuario';
        $matches = array_filter($this->Auth->user('privilegios'), function ($var) use ($search) {
          return preg_match("/$search/i", $var);
        });
        $tmp_permiso = (bool)$matches;
        break;
        case 'add': $tmp_permiso = (bool)in_array('admin_usuario_add', $this->Auth->user('privilegios')); break;
        case 'edit': $tmp_permiso = (bool)in_array('admin_usuario_edit', $this->Auth->user('privilegios')); break;
        case 'delete': $tmp_permiso = (bool)in_array('admin_usuario_delete', $this->Auth->user('privilegios')); break;
    }

    return $tmp_permiso || parent::isAuthorized($user);
  }

    /**
     * Metodo utilizado para listar los grupos en el sistema
     *
     * @param string|null $estado nombre del Estado por el cual se consulta
     **/
    public function listar($estado = 'ACTIVO')
    {
        $grupos = $this->Grupos->find('all')
            ->contain(['Estados', 'Divisiones', 'Privilegios'])
            ->where(['Estados.nombre' => $estado]);

        $this->set([
            'grupos' => $grupos,
            '_serialize' => ['grupos'],
        ]);
    }

    /**
     * Metodo utilizado para manejar la accion de crear nuevos grupos
     *
     * @return void
     */
    public function add()
    {
        $status = 'success';
        $grupo = $this->Grupos->newEntity();
        if ($this->request->is('post')) {
            $grupo = $this->Grupos->patchEntity($grupo, $this->request->data, [
              'associated' => ['Privilegios._ids', 'Areas._ids']
            ]);
            if ($this->Grupos->save($grupo)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        } else {
          $usuarios = $this->Grupos->Usuarios->find('list');
          $privilegios = $this->Grupos->Privilegios->find('list')->order(['nombre' => 'ASC']);

          // los privilegios se mapean a un arreglo
          $privilegios2 = [];
          foreach ($privilegios->toArray() as $id => $privilegio) {
            $modulo = explode('_', $privilegio)[0];
            $seccion = explode('_', $privilegio)[1];
            $permiso = explode('_', $privilegio)[2];
            if (!array_key_exists($modulo, $privilegios2)) {
              $privilegios2[$modulo] = [];
            }
            if (!array_key_exists($seccion, $privilegios2[$modulo])) {
              $privilegios2[$modulo][$seccion] = [];
            }
            if (!array_key_exists($permiso, $privilegios2[$modulo][$seccion])) {
              $privilegios2[$modulo][$seccion][$permiso] = $id;
            }
          }

          $this->set('privilegios2', $privilegios2);

          $divisiones = $this->Grupos->Divisiones->find('list');
          $areas = $this->Grupos->Areas->find('list');
          $this->set(compact('usuarios', 'privilegios', 'divisiones', 'areas'));
        }
        $this->set('grupo', $grupo);
        $this->set('status', $status);
        $this->set('_serialize', ['grupo']);
    }

    /**
     * Metodo para manejar la accion de editar
     *
     * @param string|null $id id del Grupo a consultar.
     */
    public function edit($id = null)
    {
        $status = 'success';
        $grupo = $this->Grupos->get($id, [
            'contain' => ['Privilegios', 'Areas']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $grupo = $this->Grupos->patchEntity($grupo, $this->request->data);
            if ($this->Grupos->save($grupo)) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }

        $privilegios = $this->Grupos->Privilegios->find('list')->order(['nombre' => 'ASC']);

        // los privilegios se mapean a un arreglo
        $privilegios2 = [];
        foreach ($privilegios->toArray() as $id => $privilegio) {
          $modulo = explode('_', $privilegio)[0];
          $seccion = explode('_', $privilegio)[1];
          $permiso = explode('_', $privilegio)[2];
          if (!array_key_exists($modulo, $privilegios2)) {
            $privilegios2[$modulo] = [];
          }
          if (!array_key_exists($seccion, $privilegios2[$modulo])) {
            $privilegios2[$modulo][$seccion] = [];
          }
          if (!array_key_exists($permiso, $privilegios2[$modulo][$seccion])) {
            $privilegios2[$modulo][$seccion][$permiso] = $id;
          }
        }

        $this->set('privilegios2', $privilegios2);

        $divisiones = $this->Grupos->Divisiones->find('list');
        $estados = $this->Grupos->Estados->find('list');
        $areas = $this->Grupos->Areas->find('list');
        $this->set(compact('grupo', 'privilegios', 'divisiones', 'estados', 'status', 'areas'));
        $this->set('_serialize', ['grupo']);
    }

    /**
     * Metodo para manejar la acción de borrar
     *
     * @param string|null $id id del Grupo a borrar.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $grupo = $this->Grupos->get($id);
        if ($this->Grupos->delete($grupo)) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        $this->set(compact('status'));
    }
}
