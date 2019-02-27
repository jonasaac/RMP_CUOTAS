<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class AuxiliarForm extends Form
{
    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('fullrut', 'string')
                      ->addField('nombre', ['type' => 'string'])
                      ->addField('domicilio', ['type' => 'string'])
                      ->addField('ciudad', ['type' => 'select'])
                      ->addField('funciones', ['type' => 'select']);
    }

    protected function _buildValidator(Validator $validator)
    {
        return $validator->notEmpty('fullrut', 'Debe ingresar un RUT')
                         ->add('fullrut',[
                             'validFormat' => ['rule' => ['custom', '/^([1-9][0-9]|0[1-9])(\.[0-9]{3}){2}\-[0-9kK]{1}$/i'],
                                               'message' => 'El RUT ingresado debe tener un formato valido. p.e: 12.345.678-K'],
                             'custom' => ['rule' =>
                                 function ($value, $context) {
                                     if (substr($value, -1) == $this->getDigito(substr($value, 0, -2)))
                                         return true;
                                     return false;
                                 },
                                          'message' => 'El RUT es invalido, por favor compruebe los datos ingresados.'],
                             'maxlength' => ['rule' => ['maxLength', 12]]])
                         ->notEmpty('nombre', 'Debe ingresar un nombre.')
                         ->add('nombre', 'size', [
                             'rule' => ['lengthBetween', 10, 40],
                             'message' => 'Debe ingresar un nombre con mínimo 10 y máximo 40 carácteres.',
                         ])
                         ->notEmpty('domicilio', 'Debe ingresar un domicilio.')
                         ->notEmpty('funciones', 'Un auxiliar debe cumpliar al menos una función.');
    }

    protected function _execute(array $data)
    {
        $funciones = ['chofer', 'capitan', 'armador', 'encargado_planta', 'destinatario'];
        $dataFormated = $data;
        $dataFormated['rut'] = $this->limpiarRut($data['fullrut']);
        $dataFormated['verificador'] = $this->getDigito($dataFormated['rut']);
        $dataFormated['estado'] = 1;
        foreach ($funciones as $funcion) {
            $dataFormated[$funcion] = 0;
        }
        foreach ($data['funciones'] as $funcion) {
            $dataFormated[$funcion] = 1;
        }

        $auxiliares = TableRegistry::get('Auxiliares');
        $auxiliar = $auxiliares->newEntity();
        $auxiliar = $auxiliares->patchEntity($auxiliar, $dataFormated);

        if($auxiliares->save($auxiliar))
            return true;
        else
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
?>
