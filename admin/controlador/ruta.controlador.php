<?php 
	Class ControladorRuta{
		static public function ctrRuta(){
			return "http://localhost/tupvl/";
			//return 'https://www.tupvl.com/';
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
		        'bd' => 'jun23tud_tupvl_db',
		        'user' => 'jun23tud_tupvl',
		        'contra' => 'tupvl_2021Chris0073',
		    ] ;		
		}
	}
 ?>