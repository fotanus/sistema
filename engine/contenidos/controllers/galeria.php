<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of galeria
 *
 * @author Estudio
 */
class Galeria extends Load {

    function index() {
        die;
    }

    function obtenerGaleria() {
        global $config;
        $config['debug'] = false;
        $config['functions']['secure']->security(); 

        $config['functions']['parsepages']->loadLibrary('lb_galeria');
        
        $inicio = 0;
        
        if(isset($_POST['inicio']) && empty($_POST['inicio'])){
            $inicio = $_POST['inicio'];
        }
        
        if(empty($inicio)) $inicio = 0;
        
        $html = $config['librerias']['lb_galeria']->GetHTML($inicio);
        
        echo json_encode($html);
    }

}
