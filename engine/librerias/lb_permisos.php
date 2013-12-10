<?php

if (!isset($config['fullpath'])) {
    die;
}

if (true == false) {
    include_once("../functions/mysql.php");
}

$config['functions']['parsepages']->loadFunction('mysql', FALSE);

class lb_permisos extends MySQL {

    function __construct() {
        parent::__construct();
    }

    function __destruct() {
        parent::__destruct();
    }

    function listar($modificable = FALSE) {
        global $config;
        $sql = "SELECT Permiso_Id, Nombre FROM permisos WHERE Owner ";
        
        if(!$modificable){
            $sql .= "IN (2, " . $_SESSION['sesion']['usuario']['Owner'] .")";
        } else {
            $sql .= "= " . $_SESSION['sesion']['usuario']['Owner'];
        }
        
        $result = parent::QueryArray($sql, MYSQL_NUM);

        echo $config['functions']['general']->dropdownmenu($result, true, 'lPermisos', '');
    }

    function obtenerDetalles($id_permiso, $from = 'detalle') {
        global $config;

        if ($from == 'detalle') {
            $sql = "select pd.Id_Permisos_Detalles from permisos_permisos_detalles ppd
					  inner join permisos_detalles pd on pd.Id_Permisos_Detalles = ppd.FK_Permisos_detalles_Id
					where ppd.FK_Permisos_Id = " . parent::SQLValue($id_permiso);
        } else if ($from == 'usuario') {
            $sql = "select FK_permiso_id from permisos_usuarios pu
					where FK_usuario_id = " . parent::SQLValue($id_permiso);
        }

        $result = parent::QueryArray($sql, MYSQL_NUM);

        return $result;
    }

    function agregarPermiso($nombre_permiso) {

        $insert['nombre'] = parent::SQLValue($nombre_permiso);
        $insert['Owner'] = $_SESSION['sesion']['usuario']['Owner'];

        $id = parent::AutoInsertUpdate("permisos", $insert, $insert);

        if ($id != FALSE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function asignarPermiso($id_usuario, $id_permiso) {
        global $config;

        $insert['FK_usuario_id'] = parent::SQLValue($id_usuario);
        parent::DeleteRows("permisos_usuarios", $insert);

        $insert['FK_permiso_id'] = parent::SQLValue($id_permiso);

        $result = parent::AutoInsertUpdate("permisos_usuarios", $insert, $insert);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function asiganarPermisos($id_permiso, $id_detalles) {
        global $config;

        $insert['FK_Permisos_Id'] = parent::SQLValue($id_permiso);
        $where['FK_Permisos_Id'] = parent::SQLValue($id_permiso);

        parent::DeleteRows("permisos_permisos_detalles", $where);

        foreach ($id_detalles as $value) {

            $insert['FK_Permisos_detalles_Id'] = parent::SQLValue($value);
            $where['FK_Permisos_detalles_Id'] = parent::SQLValue($value);

            $result[] = parent::AutoInsertUpdate("permisos_permisos_detalles", $insert, $where);
        }

        if (in_array(FALSE, $result)) {
            return false;
        } else {
            return true;
        }
    }

    function listarDetalles() {
        global $config;
        $sql = "SELECT Id_Permisos_Detalles, Nombre FROM permisos_detalles";
        $result = parent::QueryArray($sql, MYSQL_NUM);

        echo $config['functions']['general']->dropdownmenu($result, true, 'lPermisosDetalles');
    }

}

?>