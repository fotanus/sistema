<?php if (!defined('CODEBASE')) { die; }

include 'dBug.php';

class Debug {

    var $overrideDebug = false;
    var $cl = NULL;

    function __construct(&$data) {
        $this->cl =& $data;
    }

    function ShowDebug() {
        if ($this->cl->config['debug'] && !$this->overrideDebug) {
            $this->preprint();
        }
    }

    private function preprint() {
        new dBug($this->cl);
        new dBug($_SESSION);
    }
}
