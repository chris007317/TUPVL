<?php 
	Class ControladorAlmacen{
		/*----------  Mostrar el almacen de productos  ----------*/
		static public function ctrMostrarAlmacen($idMunicipalidad){
			$respuesta = new ModeloAlmacen();
			return $respuesta->mdlMostrarAlmacen($idMunicipalidad);
		}
		/*----------  Mostrar el productos disponibles  ----------*/
		static public function VerProductos($idMunicipalidad){
			$respuesta = new ModeloAlmacen();
			return $respuesta->mdlVerProductos($idMunicipalidad);
		}

				/*----------  Mostrar el productos disponibles  ----------*/
		static public function ctrContarProductos($nombre, $idMunicipalidad){
			$respuesta = new ModeloAlmacen();
			return $respuesta->mdlContarProductos($nombre, $idMunicipalidad);
		}

		static public function ctrMostrarProductoALmacen($idMunicipalidad, $item, $valor){
			$respuesta = new ModeloAlmacen();
			return $respuesta->mdlMostrarProductoALmacen($idMunicipalidad, $item, $valor);	
		}

		static public function ctrMostrarListaProductos($idMunicipalidad, $year, $nombreProducto){
			$respuesta = new ModeloAlmacen();
			return $respuesta->mdlMostrarListaProductos($idMunicipalidad, $year, $nombreProducto);		
		}

		static public function ctrRegistrarEntrega($fechaEntrega, $cantidad, $observacion, $idProducto, $idComite, $idUsuario, $fechaSalida){
			$respuesta = new ModeloAlmacen();
			return $respuesta->mdlRegistrarEntrega($fechaEntrega, $cantidad, $observacion, $idProducto, $idComite, $idUsuario, $fechaSalida);
		}
		/*----------  editar lista de entregas  ----------*/
		static public function ctrEditarListaProductos($idProducto, $mesEntrega, $yearEntrega, $cantidadProducto){
			$respuesta = new ModeloAlmacen();
			return $respuesta->mdlEditarListaProductos($idProducto, $mesEntrega, $yearEntrega, $cantidadProducto);
		}
		/*----------  editar stock almacen  ----------*/
		static public function ctrEditarStockAlmacen($idProducto, $cantidadProducto){
			$respuesta = new ModeloAlmacen();
			return $respuesta->mdlEditarStockAlmacen($idProducto, $cantidadProducto);
		}

		/*----------  contar salida  ----------*/
		static public function ctrContarSalidaComite($idComite, $idMes, $year){
			$respuesta = new ModeloAlmacen();
			return $respuesta->mdlContarSalidaComite($idComite, $idMes, $year);
		}
		/*----------  tabla salida de productos  ----------*/
		static public function ctrMostrarSalidas($year, $idMes, $idMunicipalidad){
			$respuesta = new ModeloAlmacen();
			return $respuesta->mdlMostrarSalidas($year, $idMes, $idMunicipalidad);
		}
		/*----------  mostrar una salida  ----------*/
		static public function ctrMostrarSalida($idSalida){
			$respuesta = new ModeloAlmacen();
			return $respuesta->mdlMostrarSalida($idSalida);
		}

		static public function ctrEditarSalida($idSalida, $observacion){
			if (preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $observacion) || empty($observacion) ) {
				$editar = new ModeloAlmacen();
				$respuesta = $editar->mdlEditarSalida($idSalida, $observacion);
				if ($respuesta) {
					return 'ok';
				}else{
					return 'error';
				}
			}else{
				return 'novalido';
			}
		}
		/*----------  Consultar reporte de salidas  ----------*/
		static public function ctrReporteSalidas($idMunicipalidad){
			$respuesta = new ModeloAlmacen();
			return $respuesta->mdlReporteSalidas($idMunicipalidad);	
		}
		/*----------  contar las salidas  ----------*/
		static public function ctrContarSalidas($idMunicipalidad, $valor){
			$respuesta = new ModeloAlmacen();
			return $respuesta->mdlContarSalidas($idMunicipalidad, $valor);		
		}
		/*----------  generar las pecosas  ----------*/
		static public function ctrGenerarPecosa($idMunicipalidad, $idComite, $mes, $year){
			$respuesta = new ModeloAlmacen();
			return $respuesta->mdlGenerarPecosa($idMunicipalidad, $idComite, $mes, $year);	
		}
	}