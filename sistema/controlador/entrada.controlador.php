<?php 
	Class ControladorEntrada{
		/*----------  Nueva entrada  ----------*/
		static public function ctrNuevaEntrada(){
			if (isset($_POST['cmbEntradaProductos']) && isset($_POST['cmbEntradaProveedores']) && isset($_POST['dateEntradaProducto']) &&
				!empty($_POST['cmbEntradaProductos']) && !empty($_POST['cmbEntradaProveedores']) && !empty($_POST['dateEntradaProducto'])) {
				$observacion = trim($_POST['txtObservacionEntrada']);
				if (validarFecha($_POST['dateEntradaProducto']) && compararFechas(date('Y-m-d'), $_POST['dateEntradaProducto']) &&
					preg_match('/^[0-9]+$/', $_POST['txtCantidadEntrada']) && (preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtObservacionEntrada"]) || empty($_POST['txtObservacionEntrada']))){
					$idProducto = $_POST['cmbEntradaProductos'];
					$idProveedor = $_POST['cmbEntradaProveedores'];
					$fecha = $_POST['dateEntradaProducto'];
					$cantidad = intval($_POST['txtCantidadEntrada']);
					$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
					$idUsuario = $_SESSION['idUsuarioPvl'];
					$agregar = new ModeloEntrada();
				 	$respuesta = $agregar->mdlNuevaEntrada($idProducto, $idProveedor, $fecha, $cantidad, $observacion, $idMunicipalidad, $idUsuario);
					if($respuesta > 0) {
						$agregarAlmacen = new ModeloAlmacen();
					 	$respuestaAlmacen = $agregarAlmacen->mdlNuevoAlmacen($idProducto, $cantidad);
					 	if ($respuestaAlmacen > 0) {
							echo mensaje('¡CORRECTO!', '¡Los datos han sido registrados con exito!', 'success');
					 	}else{
					 		echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar los datos!', 'error');	
					 	}
				 	}else{
				 		echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar los datos!', 'error');
				 	}
				}else{
					echo mensaje('¡ERROR!', '¡Las fecha ingresada no es valida!', 'error');	
				}
			}
		}
		/*----------  Mostrar Entradas tabla  ----------*/
		static public function ctrMostrarEntradas($idMunicipalidad){
			$respuesta = new ModeloEntrada();
			return $respuesta->mdlMostrarEntradas($idMunicipalidad);
		}
	}