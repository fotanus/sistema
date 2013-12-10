<?php if(!isset($config['fullpath'])) { die; } ?>

<?php

class Teclado{
	
	function __construct(){
	}
	
	function showHTML(){
		include('tecladohtml.html');
	}
}