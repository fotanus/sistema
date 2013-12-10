<?php if (true == false) { ?>
    <link href="../../../../Styles/960_12_col.css" rel="stylesheet" type="text/css">
    <link href="../../../../Styles/sistema.css" rel="stylesheet" type="text/css">
<?php } ?>
<div class="container_12 fk-main-container">
    <div class="grid_12">
        <div class="fk-forma">
            <h3>Crea tu usuario!</h3>
            <input type="text" placeholder=" Nombre" name="a_Nombre">
            <input type="text" placeholder=" Apellido" name="a_Apellido">
            <input type="text" placeholder=" Correo Electrónico" name="a_Email">
            <input type="password" placeholder=" Contraseña" name="a_Password">
            <input type="password" placeholder=" Contraseña" name="b_Password">
            <input type="button" value="Crear" id="btnNuevoUsuario"/>
        </div>
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo $GLOBALS['loadpage']->functions->url->returnPath('scripts/sistema.js'); ?>"></script>
<script>
    $(document).ready(function(e) {
        $('#btnNuevoUsuario').click(function() {
            var a_Nombre = $('.fk-forma').find('input[name="a_Nombre"]').val();
            var a_Apellido = $('.fk-forma').find('input[name="a_Apellido"]').val();
            var a_Email = $('.fk-forma').find('input[name="a_Email"]').val();
            var a_Password = $('.fk-forma').find('input[name="a_Password"]').val();
            $.ajax({
                url: '../usuario/add',
                data: {Nombre: a_Nombre, Apellido: a_Apellido, Email: a_Email, Password: a_Password},
                type: 'POST',
                success: function(output) {
                    var dt = $.parseJSON(output);
                    showErrorMsg(dt.mensaje, dt.tipo);
                    if(dt.rload){
                        window.location = '<?php echo $GLOBALS['loadpage']->functions->url->returnUrl('sistema/dashboard'); ?>'
                    }
                }
            });
        });
    });
</script>