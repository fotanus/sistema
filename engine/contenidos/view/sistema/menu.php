<?php
if (!isset($config['fullpath'])) {
    die;
}
$config['functions']['secure']->security();
?>
<div class="container_12 fk-main-container">
    <div class="grid_12" id="main-menu-container">
        <div>
            <ul class="fk-main-menu">
                <li class="fk-li-side"><a href="<?php echo $config['functions']['url']->returnURL('sistema/dashboard'); ?>">Dashboard</a></li>
                <li class="fk-li-side"><a href="<?php echo $config['functions']['url']->returnURL('sistema/configuracion'); ?>">Configuración</a>
                    <ul>
                        <li><a href="<?php echo $config['functions']['url']->returnURL('productos/nuevo'); ?>">Producto Nuevo</a></li>
                        <li><a href="<?php echo $config['functions']['url']->returnURL('sistema/usuarios'); ?>">Usuarios</a></li>
                        <li><a href="<?php echo $config['functions']['url']->returnURL('sistema/permisos'); ?>">Permisos</a></li>
                        <li><a href="<?php echo $config['functions']['url']->returnURL('sistema/configpermisos'); ?>">Configurar Permisos</a></li>
                    </ul>
                </li>
                <li class="fk-li-side"><a href="<?php echo $config['functions']['url']->returnURL('sistema/salir'); ?>">Salir</a></li>
            </ul>
        </div>
    </div>
</div>