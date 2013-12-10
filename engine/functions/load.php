<?php

class Load extends Config {
    
    function __construct($data) {
        parent::start($data);
    }
    
    function carga($page) {
        $contenido = "engine/contenidos/view/" . $page . ".php";
        if ((include $contenido) === FALSE) {
            include 'engine/contenidos/view/404.php';
        } else {
            if(!is_object($this->config->views)){
                $this->config->views = new stdClass();
            }
            $this->config->views->$page = $page;
            //$config['views'][$page] = $page;
        }
    }

}
