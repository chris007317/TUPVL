<?php 
	Class ControladorPersona{
		/*----------  Mostrar el almacen de productos  ----------*/
		static public function ctrMostrarPersona($item, $valor){
			$respuesta = new ModeloPersona();
			return $respuesta->mdlMostrarPersona($item, $valor);
		}
	}