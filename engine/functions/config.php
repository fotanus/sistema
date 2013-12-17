<?php

define('CODEBASE', 'SISTEMAPOS');

class Config {

//If leave blank system will try to determine the path
//$config['fullpath'] = "http://localhost/fokus";
    public $config;
    public $functions;
    public $libs;
    public $controllers;
    public $views;

    function __construct() {
        $this->config['fullpath'] = "";
        $this->config['pathlevel'] = 0;
        $this->config['debug'] = true;
        $this->config['use_https'] = false;

//Database settings
        $this->config['db']['host'] = "localhost";
        $this->config['db']['base'] = "fokus";
        $this->config['db']['user'] = "root";
        $this->config['db']['pass'] = "ylmd25oi";

//Encription settings
        $this->config['encrypt']['token'] = "Y3tqLtioUL17454GkGp6fhH2gBlD7R12";

//Session settings
        $this->config['session']['timeout'] = 86400;

        $this->config['sistema']['plataforma'] = 'Fokus';
        $this->config['sistema']['codename'] = 'Kapiu';
        $this->config['sistema']['version'] = '0.6b';
    }
    
    function start($data){
        $this->config =& $data->config;
        $this->functions =& $data->functions;
        $this->libs =& $data->libs;
        $this->controllers =& $data->controllers;
    }
    
    function convert($size) {
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }
    
    function logUse($function, $file, $line){
        $this->config['Memory'][] = 'Obj: ' . $function ." -> ".$file." Line: ".$line. ' Start: ' . microtime(true) . ' Memory: ' . $this->convert(memory_get_usage());
    }
}
