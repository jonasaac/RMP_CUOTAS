<?php
/** Crea notificaciones default
Usado para crear notificiaciones mediante toastr
**/
$class = 'info';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
?>
<?= $this->append('jquery') ?>
<script>
toastr.options = {
  "closeButton": true,
  "debug": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "onclick": null,
  "showDuration": "400",
  "hideDuration": "1000",
  "timeOut": "7000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};
toastr["<?= h($class) ?>"]('<?= h($message) ?>');
</script>
<?= $this->end() ?>
