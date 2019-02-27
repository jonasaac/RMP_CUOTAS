<?php
return [
    'formStart' => '<form class="form-horizontal" {{attrs}}>',
    'input' => '<input type="{{type}}" name="{{name}}" class="form-control input-xs" {{attrs}}>',
    'inputContainer' => '{{content}}',
    'inputContainerError' => '<div class="has-error has-feedback">{{content}}</div>',
    'label' => '<label class="col-sm-3 control-label">{{text}}</label>',
    'formGroup' => '<div class="form-group">{{label}}<div class="col-sm-9 m-b">{{input}}{{error}}</div></div>',
    'select' => '<select class="form-control input-xs" name="{{name}}"{{attrs}}>{{content}}</select>',
    //'button' => '<button {{attrs}}>{{text}}</button>',
    //'submitContainer' => '<div class="form-group"><div class="col-sm-4 col-sm-offset-2">{{content}}</div></div>',
    'datepicker' => '<div class="input-group input-group-xs datetime-picker" id="{{name}}-container">
                       <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                       <input name="{{name}}" type="text" class="form-control"{{attrs}}>
                     </div>',
    'timepicker' => '<div class="input-group input-group-xs time-picker" id="{{name}}-container">
                       <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                       <input name="{{name}}" type="text" class="form-control"{{attrs}}>
                     </div>',
    'textarea' => '<textarea name="{{name}}" class="form-control" {{attrs}}>{{value}}</textarea>'
];
?>
