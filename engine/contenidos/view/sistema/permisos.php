<?php if (true == false) { ?>
    <link href="../../../../Styles/960_12_col.css" rel="stylesheet" type="text/css">
    <link href="../../../../Styles/sistema.css" rel="stylesheet" type="text/css">
<?php } ?>

<?php
$config['functions']['parsepages']->loadLibrary('lb_usuario');
$config['functions']['parsepages']->loadLibrary('lb_permisos');
?>
<div class="container_12 fk-main-container">
    <?php
    //Dos espacios de grid
    $config['functions']['parsepages']->load('sistema/menu_lateral');
    ?>
    <div class="grid_10">
        <div class="grid_5 alpha">
            <h3>Crear nuevo permiso</h3>
            <input type="text" placeholder="Agregar Permiso" name="nombrePermiso"/>
            <input type="button" value="Agregar" id="agregarPermiso"/>
        </div>
    </div>
    <div class="grid_10">
        <h3>Asignar permisos a usuarios</h3>
        <div class="grid_4 alpha">
            <h4>Seleccionar usuario</h4>
            <?php $config['librerias']['lb_usuario']->listar(); ?>
        </div>
        <div class="grid_5">
            <h4>Seleccionar permiso</h4>
            <?php $config['librerias']['lb_permisos']->listar(); ?>
            <input type="button" value="Actualizar Permisos" id="asignarPermiso"/>
        </div>
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo $config['functions']['url']->returnPath('scripts/sistema.js'); ?>"></script>
<script>
    $(document).ready(function(e) {
        $('#agregarPermiso').click(function(e) {
            var nam = $('input[name="nombrePermiso"]').val();
            $.ajax({
                url: '../permisos/nuevo',
                data: {permiso: nam},
                type: 'POST',
                success: function(output) {
                    var dt = $.parseJSON(output);
                    showErrorMsg(dt.mensaje, dt.tipo, dt.rload);
                }
            });
        });
        $('#asignarPermiso').click(function(e) {
            var a_usuario = $('#lUsuarios option:selected').val();
            var a_permiso = $('#lPermisos option:selected').val();
            $.ajax({
                url: '../permisos/asignarausuario',
                data: {usuario: a_usuario, permiso: a_permiso},
                type: 'POST',
                success: function(output) {
                    console.log(output);
                    var dt = $.parseJSON(output);
                    showErrorMsg(dt.mensaje, dt.tipo, dt.rload);
                }
            });
        });
        $('#lUsuarios').click(function(e) {
            $('#lPermisos').children('option:selected').each(function(index, element) {
                $(this).removeAttr('selected');
            });
            var sel = $('#lUsuarios option:selected').val();
            $.ajax({
                url: '../permisos/obtener',
                data: {permiso: sel, tipo: 'usuario'},
                type: 'POST',
                success: function(output) {
                    console.log(output);
                    var dt = $.parseJSON(output);
                    $(dt.selc).each(function(index, element) {
                        var opt = "option[value=" + element + "]";
                        $('#lPermisos').find(opt).attr('selected', true);
                    });
                }
            });
        });
    });
</script>