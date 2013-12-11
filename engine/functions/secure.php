<?php if (!defined('CODEBASE')) { die; }

class Secure {

    var $cl = NULL;

    function __construct(&$data) {
        $this->cl = & $data;
    }

    function security() {
        if ($_SESSION['sesion']['loggedin'] == FALSE) {
            $this->logout();
        }
    }

    function logout() {
        $_SESSION = array();
        session_destroy();

        $this->functions->general->redirigir();
    }
    
    function forbidden(){
        $this->functions->general->redirigir("forbidden");
    }

    function checkLevels($function_id = NULL) {
        
        if ($function_id != NULL) {
            if(isset($_SESSION['sesion']['usuario']['Permisos'])){
                if(!in_array($function_id, $_SESSION['sesion']['usuario']['Permisos'])){
                    if(!in_array(1, $_SESSION['sesion']['usuario']['Permisos'])){
                        $this->forbidden();
                        die;
                    }
                }
            } else {
                $this->forbidden();
                die;
            }
        }
    }
}
