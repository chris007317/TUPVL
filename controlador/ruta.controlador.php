<?php

class ControladorRuta{

	static public function ctrRuta(){
		//return 'https://www.tupvl.com/';
		return "http://localhost/tupvl/";
		//return "http://192.168.0.8/reservas-hotel/";
 
	}

	static public function ctrServidor(){
		//return 'https://www.tupvl.com/sistema/';
		return "http://localhost/tupvl/sistema/";
		//return "http://192.168.0.8/reservas-hotel/backend/";
	}

	static public function ctrBdAdmin(){
		return $bd =[
	        'bd' => 'admin-pvl',
	        'user' => 'root',
	        'contra' => '',
	    ] ;
	}

	static public function ctrBdSistema(){
		return $bd =[
	        'bd' => 'pvl-bd',
	        'user' => 'root',
	        'contra' => '',
	    ] ;	
	}
}