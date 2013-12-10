<?php
//if(!isset($config['fullpath'])) { die; }

class Error404 extends Load{
	
	function index(){
		parent::carga('header');
		parent::carga('404');
		parent::carga('footer');
	}
	
	function ingreso(){
		parent::carga('header');
                parent::carga('sistema/menu');
		parent::carga('404');   
		parent::carga('footer');
	}
}