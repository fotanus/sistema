<?php if (!defined('CODEBASE')) { die; }

$GLOBALS['loadpage']->loadFunction('mysql', FALSE);

class lb_usuario extends MySQL {

    function __construct() {
        parent::__construct();
    }

    function __destruct() {
        parent::__destruct();
    }

    function obtenerUsuario($id) {
        $sql = "SELECT Usuario_Id, Nombre, Apellido, Email, Password, Owner FROM usuarios WHERE Usuario_Id = " . parent::SQLValue($id) . ' AND Habilitar = 1 AND Owner = ' . $_SESSION['sesion']['usuario']['Owner'];

        $result = parent::QuerySingleRowArray($sql, MYSQL_NUM);

        $usr = new User($result);

        $salida['nombre'] = $usr->nombre;
        $salida['apellido'] = $usr->apellido;
        $salida['email'] = $usr->email;

        return $salida;
    }

    function buscarUsr($usuario) {
        $sql = "SELECT Usuario_Id, Nombre, Apellido, Email, Password, Owner FROM usuarios WHERE Email = " . parent::SQLValue($usuario) . ' AND Habilitar = 1';

        $result = parent::QuerySingleRowArray($sql, MYSQL_NUM);

        if ($result != FALSE) {
            $usr = new User($result);
            return $usr->obtArray();
        } else {
            return FALSE;
        }
    }

    function buscar($usuario, $password) {
        $sql = "SELECT Usuario_Id, Nombre, Apellido, Email, Password, Owner FROM usuarios WHERE Email = " . parent::SQLValue($usuario) . ' AND Habilitar = 1';

        $result = parent::QuerySingleRowArray($sql, MYSQL_NUM);

        if ($result != FALSE) {
            $usr = new User($result);
            if ($usr->password == $password) {
                return $usr->obtArray();
            } else {
                return false;
            }
        }
    }

    function obtenerPermisos($owner, $id) {
        if (!empty($id)) {
            /*$sql = "select pd.Id_Permisos_Detalles from permisos_usuarios pu
                inner join permisos_permisos_detalles ppd on pu.FK_permiso_id = ppd.FK_Permisos_Id
                inner join permisos p on p.Permiso_Id = ppd.FK_Permisos_Id
                inner join permisos_detalles pd on pd.Id_Permisos_Detalles = ppd.FK_Permisos_detalles_Id
                WHERE p.Owner = " . $owner . " and pu.FK_usuario_id = " . $id;*/
            
            $sql = "select p.Permiso_Id from permisos_usuarios pu
                        inner join permisos p on pu.FK_permiso_id = p.Permiso_Id
                    WHERE FK_usuario_id = " . $id;

            $result = parent::QueryArray($sql, MYSQL_NUM);

            $salida = array();
            if (is_array($result)) {
                foreach ($result as $key => $value) {
                    $salida[] = $value[0];
                }
            }

            if ($result != FALSE) {
                return $salida;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function listar() {
        global $config;
        $sql = "SELECT Usuario_Id, CONCAT(Nombre, ' ', Apellido) Nombre FROM usuarios WHERE Owner = " . $_SESSION['sesion']['usuario']['Owner'] . ' AND Habilitar = 1';
        $result = parent::QueryArray($sql, MYSQL_NUM);

        echo $config['functions']['general']->dropdownmenu($result, true, 'lUsuarios');
    }

    function listarUsuario() {
        /*$sql = "SELECT Usuario_Id 'Número Usuario', CONCAT(Nombre, ' ', Apellido) Nombre, Email "
                . "FROM usuarios WHERE Owner = " . $_SESSION['sesion']['usuario']['Owner'] . " AND Habilitar = 1";*/
        
        $sql = "select u.Usuario_Id 'Número Usuario', CONCAT(u.Nombre, ' ', u.Apellido) Nombre, u.Email, p.Nombre 'Rol' from usuarios u
                    inner join permisos_usuarios pu on u.Usuario_Id = pu.FK_usuario_id
                    inner join permisos p on p.Permiso_Id = pu.FK_permiso_id
                WHERE u.Owner = " . $_SESSION['sesion']['usuario']['Owner'] . " AND Habilitar = 1";
        
        parent::QueryArray($sql, MYSQL_NUM);
        echo parent::GetHTML(false);
    }

    function update($usuario) {
        $id = parent::AutoInsertUpdate("usuarios", $usuario->obtArray(), $usuario->obtArray(TRUE));

        if ($id != FALSE) {
            return TRUE;
        } else {
            return "Se produjo un error al actualizar al usuario.";
        }
    }

    function nuevo($id, $nombre, $apellido, $email, $password, $owner = FALSE) {
        global $config;

        $result['error'] = FALSE;

        $donde['Email'] = parent::SQLValue($email);



        if (trim($id) == "") {
            $where['Usuario_Id'] = -1;
        } else {
            $where['Usuario_Id'] = $id;
        }

        if (trim($password) != "") {
            $contrasena = $config['functions']['encrypt']->Encrypt($password);
            $contrasena = parent::SQLValue($contrasena);
            $insert['Password'] = $contrasena;
        }
        if (trim($nombre) != "")
            $insert['Nombre'] = parent::SQLValue($nombre);

        if (trim($apellido) != "")
            $insert['Apellido'] = parent::SQLValue($apellido);

        if (trim($email) != "")
            $insert['Email'] = parent::SQLValue($email);

        $id_usuario = parent::AutoInsertUpdate("usuarios", $insert, $where);

        $result['error'] = FALSE;

        if ($id != FALSE && trim($where['Usuario_Id']) == -1) {
            $where['Usuario_Id'] = $id_usuario;
            if ($owner != FALSE) {
                $update['Owner'] = $owner;
            } else {
                $update['Owner'] = $id_usuario;
                $config['functions']['parsepages']->loadLibrary('lb_permisos', FALSE);
                $config['librerias']['lb_permisos']->asignarPermiso($id_usuario, 1);
            }
            parent::AutoInsertUpdate("usuarios", $update, $where);
            $result['mensaje'] = 'El usuario fue agregado';
            $result['error'] = FALSE;
        } else if ($id != FALSE && trim($where['Usuario_Id']) != -1) {
            $result['mensaje'] = 'El usuario se actualizo.';
            $result['error'] = FALSE;
        } else {
            $result['sqlerror'] = parent::Error();
            $result['sql'] = parent::GetLastSQL();
            $result['error'] = TRUE;
            $result['mensaje'] = 'No se pudo agregar el usuario, intente de nuevo.';
        }

        return $result;
    }

}

class User {

    public $id = '';
    public $nombre = '';
    public $apellido = '';
    public $email = '';
    public $password = '';
    public $owner = '';

    function __construct() {
        $arr = FALSE;
        if (func_num_args() > 0 && func_num_args() <= 1) {
            $numargs = func_get_arg(0);
        } else if (func_num_args() > 1) {
            $numargs = func_get_args();
        }
        $this->asignar($numargs[0], $numargs[1], $numargs[2], $numargs[3], $numargs[4], $numargs[5]);
    }

    function obtArray($where = FALSE) {
        global $config;
        if (!$where) {
            $arr['Id'] = parent::SQLValue($this->id);
            $arr['Nombre'] = parent::SQLValue($this->nombre);
            $arr['Apellido'] = parent::SQLValue($this->apellido);
            $arr['Email'] = parent::SQLValue($this->email);
            $arr['Password'] = $config['functions']['encrypt']->Encrypt(parent::SQLValue($this->password));
            $arr['Owner'] = parent::SQLValue($this->owner);
        } else {
            $arr['Usuario_Id'] = parent::SQLValue($this->id);
            $arr['Owner'] = parent::SQLValue($this->owner);
        }
        return $arr;
    }

    function asignar($a_id, $a_nombre, $a_apellido, $a_email, $a_password, $a_owner) {
        global $config;
        $this->id = $a_id;
        $this->nombre = $a_nombre;
        $this->apellido = $a_apellido;
        $this->email = $a_email;
        $this->password = $config['functions']['encrypt']->Decrypt($a_password);
        $this->owner = $a_owner;
    }

}

?>