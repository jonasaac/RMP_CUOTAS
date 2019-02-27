<?php
namespace App\View\Widget;

use Cake\View\Widget\WidgetInterface;
use Cake\View\Form\ContextInterface;

class DatepickerWidget implements WidgetInterface
{
    protected $_templates;

    public function __construct($templates)
    {
        $this->_templates = $templates;
    }

    public function render(array $data, ContextInterface $context)
    {
        $data += [
            'name' => '',
            'val' => null,
            'label' => null,
        ];

        if(empty($data['val']))
            $data['val'] = date('d/m/Y');

        $data['value'] = $data['val'];
        unset($data['val']);

        $label = $this->_templates->format('label', [
            'text' => $data['label'],
        ]);

        $datepicker = $this->_templates->format('datepicker', [
            'name' => $data['name'],
            'attrs' => $this->_templates->formatAttributes($data, ['name'])
        ]);

        return $datepicker;
    }

    public function secureFields(array $data)
    {
        return [$data['name']];
    }
}
?>
