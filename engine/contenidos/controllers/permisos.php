<?php
//if(!isset($config['fullpath'])) { die; }

class Permisos extends Load{
	
	function index(){
		parent::carga('sistema/login_form');
	}
	
	function obtener(){
		global $config;
		$config['debug'] = false;
		$config['functions']['secure']->security();
		$config['functions']['secure']->checkLevels();
		
		$config['functions']['parsepages']->loadLibrary('lb_permisos');
		
		if(isset($_POST['tipo'])){
			$tp = $_POST['tipo'];
		} else {
			$tp = 'detalle';
		}
		
		$values = $config['librerias']['lb_permisos']->obtenerDetalles($_POST['permiso'], $tp);
		
		echo json_encode(array("selc"=>$values));
	}
	
	function nuevo(){
		global $config;
		$config['debug'] = false;
		$config['functions']['secure']->security();
		$config['functions']['secure']->checkLevels(9);
		
		$config['functions']['parsepages']->loadLibrary('lb_permisos');
		
		$values = $config['librerias']['lb_permisos']->agregarPermiso($_POST['permiso']);
		
		$salida['mensaje'] = 'No se pudo procesar la información';
		$salida['tipo'] = 1;
		$salida['rload'] = false;
		if($values){
			$salida['mensaje'] = 'La información ha sido actualizada';
			$salida['tipo'] = 0;
			$salida['rload'] = true;
		}
		
		echo json_encode($salida);
	}
	
	function asignarausuario(){
		global $config;
		$config['debug'] = false;
		$config['functions']['secure']->security();
		$config['functions']['secure']->checkLevels(8);
		
		$config['functions']['parsepages']->loadLibrary('lb_permisos');
		
		$values = $config['librerias']['lb_permisos']->asignarPermiso($_POST['usuario'], $_POST['permiso']);
		
		$salida['mensaje'] = 'No se pudo procesar la información';
		$salida['tipo'] = 1;
		if($values){
			$salida['mensaje'] = 'La información ha sido actualizada';
			$salida['tipo'] = 0;
		}
		
		echo json_encode($salida);
	}
	
	function asignar(){
		global $config;
		$config['debug'] = false;
		$config['functions']['secure']->security();
		$config['functions']['secure']->checkLevels(7);
		
		$config['functions']['parsepages']->loadLibrary('lb_permisos');
		
		$valores = array_filter(explode(":", $_POST['detalles']));
		
		$values = $config['librerias']['lb_permisos']->asiganarPermisos($_POST['permiso'], $valores);
		
		$salida['mensaje'] = 'No se pudo procesar la información';
		$salida['tipo'] = 1;
		if($values){
			$salida['mensaje'] = 'La información ha sido actualizada';
			$salida['tipo'] = 0;
		}
		
		echo json_encode($salida);
	}
}