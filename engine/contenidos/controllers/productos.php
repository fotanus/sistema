<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Noticiasyeventos
 *
 * @author Kap
 */
if (!isset($config['fullpath'])) {
    die;
}

class Productos extends Load {

    function index() {
        global $config;
        $config['functions']['secure']->security();
        $config['functions']['secure']->checkLevels(10);

        parent::carga('header');
        parent::carga('sistema/menu');
        parent::carga('sistema/productonuevo');
        parent::carga('footer');
    }
    
    function nuevo(){
        $this->index();
    }
    
    function agregar(){
        
    }

    function nueva() {
        global $config;
        $config['debug'] = false;
        $config['functions']['secure']->security();
        $config['functions']['secure']->checkLevels(10);

        $config['functions']['parsepages']->loadLibrary('lb_noticiasyeventos');
        
        $id = $_POST['idNoticia'];
        $titulo = $_POST['tituloNoticia'];
        $desc = $_POST['descNoticia'];
        $imagen = $_POST['imgNoticia'];
        
        $values = $config['librerias']['lb_noticiasyeventos']->nueva($id, $titulo, $desc, $imagen);

        $salida['mensaje'] = 'No se pudo procesar la información';
        $salida['tipo'] = 1;
        $salida['rload'] = false;
        if ($values != FALSE) {
            $salida['mensaje'] = 'La información ha sido actualizada';
            $salida['tipo'] = 0;
            $salida['rload'] = true;
        }

        echo json_encode($salida);
    }

}
