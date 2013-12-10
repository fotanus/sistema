<?php

if (!isset($config['fullpath'])) {
    //die;
}

class Secure extends Config {

    function __construct($data) {
        parent::start($data);
    }

    function security() {
        if ($_SESSION['sesion']['loggedin'] == FALSE) {
            $this->logout();
        }
    }

    function logout() {
        

        $_SESSION = array();
        session_destroy();

        $this->config['functions']['general']->redirigir();
    }
    
    function forbidden(){
        
        $this->config['functions']['general']->redirigir("forbidden");
    }

    function checkLevels($function_id = NULL) {
        
        if ($function_id != NULL) {
            if(isset($_SESSION['sesion']['usuario']['Permisos'])){
                if(!in_array($function_id, $_SESSION['sesion']['usuario']['Permisos'])){
                    if(!in_array(1, $_SESSION['sesion']['usuario']['Permisos'])){
                        $this->forbidden();
                        //die;
                    }
                }
            } else {
                $this->forbidden();
                //die;
            }
        }
    }
}
