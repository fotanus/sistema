<?php

if (!isset($config['fullpath'])) {
    die;
}

class Usuario extends Load {

    function index() {
        parent::carga('sistema/login_form');
    }

    function nuevo() {
        global $config;
        $config['functions']['secure']->security();
        $config['functions']['secure']->checkLevels(4);

        parent::carga('header');
        parent::carga('sistema/forma_nuevo');
        parent::carga('footer');
    }

    function obtenerdatos() {
        global $config;
        $config['functions']['secure']->security();
        $config['functions']['secure']->checkLevels(4);
        $config['debug'] = false;

        $salida = array();

        $config['functions']['parsepages']->loadLibrary('lb_usuario');

        $result = $config['librerias']['lb_usuario']->obtenerUsuario($_POST['usuario']);

        echo json_encode($result);
    }

    function ingresar() {
        global $config;
        $config['debug'] = false;

        $salida = array();
        $config['functions']['parsepages']->loadLibrary('lb_usuario');

        $result = $config['librerias']['lb_usuario']->buscar($_POST['Usuario'], $_POST['Password']);

        if ($result != FALSE) {
            $permisos = $config['librerias']['lb_usuario']->obtenerPermisos($result['Id'], $result['Owner']);
            $salida['mensaje'] = 'Espere por favor';
            $salida['tipo'] = 0;
            $salida['rload'] = true;
            $config['functions']['sesion']->Set_Session_Vars($result, $permisos);
        } else {
            $salida['mensaje'] = 'El usuario o contraseña son incorrectos';
            $salida['tipo'] = 1;
            $salida['rload'] = false;
        }

        echo json_encode($salida);
    }

    private function userAdd() {
        global $config;
        $config['debug'] = false;
        $config['functions']['parsepages']->loadLibrary('lb_usuario');
        
        $id = (isset($_POST['usrId']) ? $_POST['usrId'] : -1);
        $Owner = (isset($_SESSION['sesion']['usuario']['Owner']) ? $_SESSION['sesion']['usuario']['Owner'] : FALSE);
        
        return $config['librerias']['lb_usuario']->nuevo($id, $_POST['Nombre'], $_POST['Apellido'], $_POST['Email'], $_POST['Password'], $Owner);
    }

    function agregar() {
        $config['debug'] = false;
        
        $result = $this->userAdd();
        
        $salida = array();
        $salida['data'] = $result;
        $salida['mensaje'] = $result['mensaje'];
        $salida['tipo'] = ($result['error'] ? 1 : 0);
        $salida['rload'] = !$result['error'];

        echo json_encode($salida);
    }
    
    function add() {
        global $config;
        
        $config['debug'] = false;
        
        $result = $this->userAdd();
        
        if (!$result['error']) {
            
            $user = $config['librerias']['lb_usuario']->buscarUsr($_POST['Email']);
            
            $permisos = $config['librerias']['lb_usuario']->obtenerPermisos($user['Owner'], $user['Id']);
            
            $config['functions']['sesion']->Set_Session_Vars($user, $permisos);
            $salida['mensaje'] = 'Espere por favor';
            $salida['tipo'] = 0;
            $salida['rload'] = true;
        } else {
            $salida['mensaje'] = 'El usuario o contraseña son incorrectos';
            $salida['tipo'] = 1;
            $salida['rload'] = false;
        }
        echo json_encode($salida);
    }
}
