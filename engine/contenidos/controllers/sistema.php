<?php if (!defined('CODEBASE')) { die; }

class Sistema {
    
    var $cl = NULL;
    function __construct(&$data) {
        $this->cl =& $data;
    }

    function index() {
        $this->cl->loadView('header');
        $this->cl->loadView('sistema/login_form');
        $this->cl->loadView('footer');
    }

    function salir() {
        $this->cl->functions->secure->logout();
        //$config['functions']['secure']->logout();
    }

    function dashboard() {
        
        $this->cl->functions->secure->security();
        $this->cl->functions->secure->checkLevels(2);
                
        $this->cl->loadView('header');
        $this->cl->loadView('sistema/menu');
        $this->cl->loadView('sistema/noticiasyeventos');
        $this->cl->loadView('footer');
    }

    function configuracion() {
        $this->usuarios();
    }

    function usuarios() {
        $this->cl->functions->secure->security();
        $this->cl->functions->secure->checkLevels(4);

        $this->cl->loadView('header');
        $this->cl->loadView('sistema/menu');
        $this->cl->loadView('sistema/forma_nuevo');
        $this->cl->loadView('footer');
    }

    function permisos() {
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
