<?php

if (!isset($config['fullpath'])) {
    die;
}

if (true == false) {
    include_once("../functions/mysql.php");
}

if(!isset($out)){
    $config['functions']['parsepages']->loadFunction('mysql', FALSE);
}

class lb_productos extends MySQL {
    function __construct() {
        parent::__construct();
    }
    
    
}