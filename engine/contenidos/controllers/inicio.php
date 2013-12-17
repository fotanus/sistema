<?php if (!defined('CODEBASE')) { die; }

class Inicio {
    //put your code here
    
    var $cl = NULL;
    function __construct(&$data) {
        $this->cl =& $data;
    }
    
    function index() {
        $this->cl->loadView('header');
        $this->cl->loadView('menu');
        $this->cl->loadView('sistema/login_form');
        $this->cl->loadView('footer');
        //parent::carga('header');
        //parent::carga('menu');
        //parent::carga('sistema/login_form');
        //parent::carga('footer');
    }
}
