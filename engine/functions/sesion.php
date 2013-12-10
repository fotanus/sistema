<?php

session_start();

class Sesion extends Config {
    
    function __construct($data) {
        parent::start($data);
        $this->Init();
    }

    function Init() {
        
        if(!isset($_SESSION['sesion']['sessid'])){
            $rand = $config['functions']['general']->generateRandomString();
            $valor = time().$rand;
            $_SESSION['sesion']['sessid'] = $valor;
        }
    }
    
    function close(){
        $_SESSION = array();
        unset($_SESSION);
    }
    
    function Set_Session_Vars($usr, $permisos){
        $_SESSION['sesion']['loggedin'] = true;
        
        foreach($usr as $key => $value){
            $_SESSION['sesion']['usuario'][$key] = $value;
        }
        if($permisos != NULL){
            $_SESSION['sesion']['usuario']['Permisos'] = $permisos;
        }
    }
}
