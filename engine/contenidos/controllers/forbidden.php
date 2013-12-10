<?php

if (!isset($config['fullpath'])) {
    die;
}

class Forbidden extends Load {

    function index() {
        global $config;
        $config['functions']['secure']->security();
        
        parent::carga('header');
        parent::carga('sistema/menu');
        parent::carga('forbidden');
        parent::carga('footer');
    }

}
