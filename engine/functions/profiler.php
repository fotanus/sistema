<?php if(!isset($config['fullpath'])) { die; }

class Profiler{
	
	var $contadores = array();
	
	function __construct(){
		$this->add();
	}
	
	function add(){
		array_push($this->contadores, microtime(true));
	}
	
	function show(){
		global $config;
		
		if($config['debug']){
			$s = "<pre>";
			$s .= print_r($this->contadores, 1);
			$s .= "</pre>";
			echo $s;
		}
	}
}