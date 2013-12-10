<?php if (true == false) { ?>
    <link href="../../../../Styles/960_12_col.css" rel="stylesheet" type="text/css">
    <link href="../../../../Styles/sistema.css" rel="stylesheet" type="text/css">
    <link href="../../../../Styles/upload.css" rel="stylesheet" type="text/css">
    <?php
}

$config['functions']['parsepages']->loadLibrary('lb_noticiasyeventos');
?>
<link href="<?php echo $config['functions']['url']->returnPath('Styles/upload.css'); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo $config['functions']['url']->returnPath('Styles/jquery-te-1.4.0.css'); ?>" rel="stylesheet" type="text/css">
<div class="container_12 fk-main-container">
    <?php
    //Dos espacios de grid
    $config['functions']['parsepages']->load('sistema/menu_lateral');
    ?>
    <div class="grid_10">
        <div class="grid_10 alpha omega"><h3>Noticias y eventos</h3></div>
        <div class="grid_10 alpha omega">
            <input type="button" value="Nuevo" id="nuevaNoticia"/>
            <input type="button" value="Guardar" id="addNoticia"/>
        </div>
        <div class="grid_6 alpha">
            <div class="fk-forma" style="max-width: none;">
                <input type="hidden" value="" id="idNoticia">
                <input type="text" placeholder="Titulo" id="tituloNoticia">
                <input type="text" placeholder="Clic para seleccionar imagen" id="selImagen">
            </div>
        </div>
        <div class="grid_4 omega"><div id="fileuploader"></div></div>
        <div class="grid_10 alpha omega">
            <textarea id="editorNoticia"></textarea>
        </div>
        <div class="grid_10 alpha omega">
            <?php
            echo $config['librerias']['lb_noticiasyeventos']->listar();
            ?>
        </div>
    </div>
</div>
<div class="fk-fullscreen">
    <div class="container back-light"></div>
    <div class="container container-top"></div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo $config['functions']['url']->returnPath('scripts/sistema.js'); ?>"></script>
<script src="<?php echo $config['functions']['url']->returnPath('scripts/jquery.uploader.js'); ?>"></script>
<script src="<?php echo $config['functions']['url']->returnPath('scripts/jquery-te-1.4.0.js'); ?>"></script>
<script>
    $(document).ready(function()
    {
        $('.clicName').click(function(){
            $('#idNoticia').val($(this).parent().siblings('input[type="hidden"]').val());
            $('#tituloNoticia').val($(this).html());
            $('#selImagen').val($(this).parent().siblings('td.Imagen').find('input[type="hidden"]').val()); //imagenNoticiasName
            $('.jqte_editor').html($(this).parent().siblings('td.Descripcion').html());
        });
        $('#nuevaNoticia').click(function() {
            $('#idNoticia').val('');
            $('#tituloNoticia').val('');
            $('#selImagen').val('');
            $('.jqte_editor').html('');
        });
        $("#fileuploader").uploadFile({
            url: "<?php echo $config['functions']['url']->returnPath('uploader.php'); ?>",
            fileName: "myfile",
            multiple: false
        });
        $("#editorNoticia").jqte();
        $('#addNoticia').click(function() {
            var idNot = $('#idNoticia').val();
            var tituloNot = $('#tituloNoticia').val();
            var imgNot = $('#selImagen').val();
            var descNot = $('.jqte_editor').html();

            $.ajax({
                url: '<?php echo $config['functions']['url']->returnUrl('noticiasyeventos/nueva'); ?>',
                data: {idNoticia: idNot, tituloNoticia: tituloNot, imgNoticia: imgNot, descNoticia: descNot},
                type: 'POST',
                success: function(output) {
                    console.log(output);
                    var dt = $.parseJSON(output);
                    showErrorMsg(dt.mensaje, dt.tipo, dt.rload);
                }
            });
        });
        $('#selImagen').click(function() {
            showGal(0);
        });
        $('.fk-fullscreen').click(function(e) {
            if (e.target.tagName === "IMG") {
                $('#selImagen').val(e.target.alt);
                $('.fk-fullscreen').hide();
                $('.container-top').html();
            } else if (e.target.id === "clicAnterior") {
                var start = $('.fk-fullscreen').find('#galAnterior').val();
                showGal(start);
            } else if (e.target.id === "clicSiguiente") {
                var start = $('.fk-fullscreen').find('#galSiguiente').val();
                showGal(start);
            } else if (e.target.className === "container container-top") {
                $('.fk-fullscreen').hide();
                $('.container-top').html();
            }
        });
        function showGal(start) {
            $.ajax({
                url: '<?php echo $config['functions']['url']->returnUrl('galeria/obtenerGaleria'); ?>',
                data: {inicio: start},
                type: 'POST',
                success: function(output) {
                    var result = $.parseJSON(output);
                    $('.container-top').html(result);
                    $('.fk-fullscreen').show();
                }
            });
        }
        ;
    });
</script>