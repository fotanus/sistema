<?php if (!defined('CODEBASE')) { die; } ?>

<div class="container_12 fk-main-container fk-main-content-container">
    <div class="grid_12">
        <div class="fk-forma">
       	    <input type="text" placeholder=" Usuario" name="Usuario">
       	    <input type="password" placeholder=" Contraseña" name="Password">
       	    <input type="button" value="Ingresar" id="btnIngresar"/>
        </div>
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo $GLOBALS['loadpage']->functions->url->returnPath('scripts/sistema.js'); ?>"></script>
<script>
    $(document).ready(function(e) {
        $('#btnIngresar').click(function(e) {
            var a_usuario = $('input[name="Usuario"]').val();
            var a_password = $('input[name="Password"]').val();

            var error = false;
            if ($.trim(a_usuario) === "" || $.trim(a_password) === "") {
                error = true;
            }

            if (!error) {
                $.ajax({
                    url: '<?php echo $GLOBALS['loadpage']->functions->url->returnUrl('usuario/ingresar'); ?>',
                    data: {Usuario: a_usuario, Password: a_password},
                    type: 'POST',
                    success: function(output) {
                        console.log(output);
                        var dt = $.parseJSON(output);
                        showErrorMsg(dt.mensaje, dt.tipo);
                        if (dt.rload) {
                            document.location = '<?php echo $GLOBALS['loadpage']->functions->url->returnUrl('sistema/dashboard'); ?>';
                        }
                    }
                });
            }
        });
    });
</script>