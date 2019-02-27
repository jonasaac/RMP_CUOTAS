<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;

class ActivateBehavior extends Behavior
{
    public function beforeMarshal($event, $data, $options)
    {
        if(!isset($data['estado_id'])) {
            $data['estado_id'] = 1;
        }
    }
}
?>
