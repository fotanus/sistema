<?php if (!defined('CODEBASE')) { die; }

class Ingreso {
    
    var $cl = NULL;
    function __construct(&$data) {
        $this->cl =& $data;
    }
        
    function index() {
        $this->cl->loadView('header');
        $this->cl->loadView('menu');
        $this->cl->loadView('sistema/login_form');
        $this->cl->loadView('footer');
        /*parent::carga('header');
        parent::carga('menu');
        parent::carga('sistema/login_form');
        parent::carga('footer');*/
    }
    
    function nuevo(){
        $this->cl->loadView('header');
        $this->cl->loadView('menu');
        $this->cl->loadView('forma_nuevo');
        $this->cl->loadView('footer');
        
        /*parent::carga('header');
        parent::carga('menu');
        parent::carga('forma_nuevo');
        parent::carga('footer');*/
    }
}
