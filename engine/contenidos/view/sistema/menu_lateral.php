<?php
if (!isset($config['fullpath'])) {
    die;
}
$config['functions']['secure']->security();

if (true == false) {
    ?>
    <link href="../../../../Styles/960_12_col.css" rel="stylesheet" type="text/css">
    <link href="../../../../Styles/sistema.css" rel="stylesheet" type="text/css">
<?php } ?>
<div class="grid_2">
    <div class="fk-menu-lateral-container">
        <ul class="fk-main-menu">
            <li><a href="<?php echo $config['functions']['url']->returnURL('productos/nuevo'); ?>">Producto Nuevo</a></li>
            <li><a href="<?php echo $config['functions']['url']->returnURL('productos/buscar'); ?>">Busqueda de Productos</a></li>
            <li class="color_fondo"></li>
            <li><a href="<?php echo $config['functions']['url']->returnURL('sistema/usuarios'); ?>">Usuarios</a></li>
            <li><a href="<?php echo $config['functions']['url']->returnURL('sistema/permisos'); ?>">Asignar Permisos</a></li>
            <li><a href="<?php echo $config['functions']['url']->returnURL('sistema/configpermisos'); ?>">Configurar Permisos</a></li>
        </ul>
    </div>
</div>