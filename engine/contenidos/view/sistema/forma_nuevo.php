<?php if (true == false) { ?>
    <link href="../../../../Styles/960_12_col.css" rel="stylesheet" type="text/css">
    <link href="../../../../Styles/sistema.css" rel="stylesheet" type="text/css">
<?php } 
$config['functions']['parsepages']->loadLibrary('lb_usuario');
?>
<div class="container_12 fk-main-container">
    <?php
    //Dos espacios de grid
    $config['functions']['parsepages']->load('sistema/menu_lateral');
    ?>
    <div class="grid_10">
        <div class="grid_3 alpha">
            <div class="fk-forma">
                <h3>Agregar Usuario</h3>
                <input type="hidden" value="" name="a_Id_User">
                <input type="text" placeholder=" Nombre" name="a_Nombre">
                <input type="text" placeholder=" Apellido" name="a_Apellido">
                <input type="text" placeholder=" Correo Electrónico" name="a_Email">
                <input type="password" placeholder=" Contraseña" name="a_Password">
                <input type="button" value="Crear o Actualizar" id="btnNuevoUsuario"/>
            </div>
        </div>
        <div class="grid_7 omega">
            <?php
            $config['librerias']['lb_usuario']->listarUsuario();
            ?>
        </div>
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo $config['functions']['url']->returnPath('scripts/sistema.js'); ?>"></script>
<script>
    $(document).ready(function(e) {
        $('.nameClick').click(function(e) {
            var usrId = $(e.currentTarget).parent().find('input[type="hidden"]').val();

            $.ajax({
                url: '../usuario/obtenerdatos',
                data: {usuario: usrId},
                type: 'POST',
                success: function(output) {
                    console.log(output);
                    var dt = $.parseJSON(output);
                    $('input[name="a_Id_User"]').val(usrId);
                    $('input[name="a_Nombre"]').val(dt.nombre);
                    $('input[name="a_Apellido"]').val(dt.apellido);
                    $('input[name="a_Email"]').val(dt.email);
                }
            });
        });
        $('#btnNuevoUsuario').click(function(e) {
            var a_Nombre = $('.fk-forma').find('input[name="a_Nombre"]').val();
            var a_Apellido = $('.fk-forma').find('input[name="a_Apellido"]').val();
            var a_Email = $('.fk-forma').find('input[name="a_Email"]').val();
            var a_Password = $('.fk-forma').find('input[name="a_Password"]').val();
            var a_Id = $('.fk-forma').find('input[name="a_Id_User"]').val();
            $.ajax({
                url: '../usuario/agregar',
                data: {usrId: a_Id, Nombre: a_Nombre, Apellido: a_Apellido, Email: a_Email, Password: a_Password},
                type: 'POST',
                success: function(output) {
                    console.log(output);
                    var dt = $.parseJSON(output);
                    showErrorMsg(dt.mensaje, dt.tipo, dt.rload);
                }
            });
        });
    });
</script>