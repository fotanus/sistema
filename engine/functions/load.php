<?php if (!defined('CODEBASE')) { die; }

class Load {

    var $cl = NULL;

    function __construct(&$data) {
        $this->cl = & $data;
    }

    function carga($page) {
        $contenido = "engine/contenidos/view/" . $page . ".php";
        if ((include $contenido) === FALSE) {
            include 'engine/contenidos/view/404.php';
        } else {
            $this->cl->views[] = $page;
        }
    }
}