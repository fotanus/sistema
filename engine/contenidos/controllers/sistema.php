<?php

if (!isset($config['fullpath'])) {
    die;
}

class Sistema {
    
    var $cl = NULL;
    function __construct($data) {
        $this->cl =& $data;
    }

    function index() {
        parent::carga('header');
        parent::carga('sistema/login_form');
        parent::carga('footer');
    }

    function salir() {
        $this->cl->functions->secure->logout();
        //$config['functions']['secure']->logout();
    }

    function dashboard() {
        
        $this->cl->functions->secure->security();
        $this->cl->functions->secure->checkLevels(2);
        //$config['functions']['secure']->security();
        //$config['functions']['secure']->checkLevels(2);
        
        $this->cl->loadView('header');
        $this->cl->loadView('sistema/menu');
        $this->cl->loadView('sistema/noticiasyeventos');
        $this->cl->loadView('footer');
        /*parent::carga('header');
        parent::carga('sistema/menu');
        parent::carga('sistema/noticiasyeventos');
        parent::carga('footer');*/
    }

    function configuracion() {
        $this->usuarios();
    }

    function usuarios() {
        global $config;
        $config['functions']['secure']->security();
        $config['functions']['secure']->checkLevels(4);

        parent::carga('header');
        parent::carga('sistema/menu');
        parent::carga('sistema/forma_nuevo');
        parent::carga('footer');
    }

    function permisos() {
        global $config;
        $config['functions']['secure']->security();
        $config['functions']['secure']->checkLevels(6);

        parent::carga('header');
        parent::carga('sistema/menu');
        parent::carga('sistema/permisos');
        parent::carga('footer');
    }

    function configpermisos() {
        global $config;
        $config['functions']['secure']->security();
        $config['functions']['secure']->checkLevels(7);

        parent::carga('header');
        parent::carga('sistema/menu');
        parent::carga('sistema/configurar_permisos');
        parent::carga('footer');
    }

}
