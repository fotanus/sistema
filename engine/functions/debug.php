<?php
if(!isset($config['fullpath'])) { /*die;*/ }

include 'dBug.php';
class Debug extends Config {
	
	var $overrideDebug = false;
	
	function __construct($data){
            parent::start($data);
        }
	
	function ShowDebug(){
		
		if($this->config['debug'] && !$this->overrideDebug){
			$this->preprint();
		}
	}
	
	private function preprint() {
		new dBug($this);
		new dBug($_SESSION);
		/*new dBug($_COOKIE);
		new dBug($_POST);
		new dBug($_REQUEST);
		new dBug($_GET);
                new dBug($_SERVER);*/
    } 
}