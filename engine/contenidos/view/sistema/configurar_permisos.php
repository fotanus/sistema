<?php if (true == false) { ?>
    <link href="../../../../Styles/960_12_col.css" rel="stylesheet" type="text/css">
    <link href="../../../../Styles/sistema.css" rel="stylesheet" type="text/css">
<?php } ?>

<?php
$config['functions']['parsepages']->loadLibrary('lb_permisos');
?>

<div class="container_12 fk-main-container">
    <?php
    //Dos espacios de grid
    $config['functions']['parsepages']->load('sistema/menu_lateral');
    ?>
    <div class="grid_10">
        <h3>Modificar roles de usuario</h3>
        <div class="grid_4 alpha">
            <h4>Seleccionar permiso</h4>
            <!--lPermisos-->
            <?php $config['librerias']['lb_permisos']->listar(TRUE); ?>
        </div>
        <div class="grid_4">
            <h4>Seleccionar detalle</h4>
            <!--lPermisosDetalles-->
            <?php $config['librerias']['lb_permisos']->listarDetalles(); ?>
            <input type="button" value="Guardar" id="grdPermisos"/>
        </div>
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo $config['functions']['url']->returnPath('scripts/sistema.js'); ?>"></script>
<script>
    $(document).ready(function(e) {
        $('#lPermisos').click(function(e) {
            $('#lPermisosDetalles').children('option:selected').each(function(index, element) {
                $(this).removeAttr('selected');
            });
            var sel = $('option:selected').val();
            $.ajax({
                url: '../permisos/obtener',
                data: {permiso: sel},
                type: 'POST',
                success: function(output) {
                    var dt = $.parseJSON(output);
                    $(dt.selc).each(function(index, element) {
                        var opt = "option[value=" + element + "]";
                        $('#lPermisosDetalles').find(opt).attr('selected', true);
                    });
                }
            });
        });
        $('#grdPermisos').click(function(e) {
            var optsel = $('#lPermisos option:selected').val();
            var optdet = '';
            $('#lPermisosDetalles option:selected').each(function(index, element) {
                optdet += $(this).val() + ":";
            });
            $.ajax({
                url: '../permisos/asignar',
                data: {permiso: optsel, detalles: optdet},
                type: 'POST',
                success: function(output) {
                    console.log(output);
                    var dt = $.parseJSON(output);
                    showErrorMsg(dt.mensaje, dt.tipo);
                }
            });
        });
    });
</script>