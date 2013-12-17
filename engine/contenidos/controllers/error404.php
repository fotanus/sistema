<?php if (!defined('CODEBASE')) { die; }

class Error404 {

    var $cl = NULL;

    function __construct(&$data) {
        $this->cl = & $data;
    }

    function index() {
        $this->cl->loadView('header');
        $this->cl->loadView('404');
        $this->cl->loadView('footer');
    }

    function ingreso() {
        $this->cl->loadView('header');
        $this->cl->loadView('sistema/menu');
        $this->cl->loadView('404');
        $this->cl->loadView('footer');
        
    }

}
