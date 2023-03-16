<?php 
	Class ControladorProveedor{
		/*----------  Agregar requisitos por tipo de beneficiarios  ----------*/
		static public function ctrAgregarProveedor(){
			if (isset($_POST['txtRucProveedor']) && isset($_POST['txtNombreProveedor']) && !empty($_POST['txtRucProveedor']) && !empty($_POST['txtNombreProveedor'])) {
				if (preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['txtNombreProveedor']) && 
					preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['txtDireccionProveedor']) && 
					preg_match('/^[0-9]+$/', $_POST['txtRucProveedor']) && 
					(preg_match('/^[0-9]+$/', $_POST['txtCelularProveedor']) || empty($_POST['txtCelularProveedor'])) &&
					preg_match('/^[\/\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['txtRepresentanteProveedor']) && (preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['txtCorreoProveedor']) || empty($_POST['txtCorreoProveedor']))
				){
					$rucProveedor = trim($_POST['txtRucProveedor']);
					$nombreProveedor = trim($_POST['txtNombreProveedor']);
					$direccionProveedor = trim($_POST['txtDireccionProveedor']);
					$celularProveedor = $_POST['txtCelularProveedor'];
					$correoProveedor = $_POST['txtCorreoProveedor'];
					$representanteProveedor = $_POST['txtRepresentanteProveedor'];
					$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
					$agregar = new ModeloProveedor();
				 	$respuesta = $agregar->mdlAgregarProveedor($nombreProveedor, $rucProveedor, $direccionProveedor, $representanteProveedor, $celularProveedor, $correoProveedor, $idMunicipalidad);
				 	if($respuesta == 'existe'){
			 			echo mensaje('¡ADVERTENCIA!', '¡El proveedor ya existe!', 'warning');
				 	}else if($respuesta > 0) {
						echo mensaje('¡CORRECTO!', '¡El proveedor ha sido registrado con exito!', 'success');
				 	}else{
				 		echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar el proveedor!', 'error');
				 	}
				}else{
					echo mensaje('CORREGIR!', '¡No se permiten caracteres especiales en ninguno de los campos!', 'warning');	
				}
			}
		}
		/*----------  Mostrar planes  ----------*/
		static public function ctrMostrarProveedores($idMunicipalidad){
			$respuesta = new ModeloProveedor();
			return $respuesta->mdlMostrarProveedores($idMunicipalidad);
		}
		/*----------  mostrar proveedores activos  ----------*/
		static public function ctrMostrarProveedoresActivos($idMunicipalidad){
			$respuesta = new ModeloProveedor();
			return $respuesta->mdlMostrarProveedoresActivos($idMunicipalidad);
		}
		/*----------  editar un solo campo de un proveedor  ----------*/
		static public function ctrEditarCampoProveedor($item, $valor, $idProveedor){
			$respuesta = new ModeloProveedor();
			$editar = $respuesta->mdlEditarCampoProveedor($item, $valor, $idProveedor);	
			if($editar){
				return 'ok';
			}
		}
		/*----------  Mostrar un solo proveedor  ----------*/
		static public function ctrMostrarProveedor($idProveedor, $idMunicipalidad){
			$valor = $idProveedor;
			$atributo = 'idProveedor';
			$respuesta = new ModeloProveedor();
			return $respuesta->mdlMostrarProveedor($atributo, $valor, $idMunicipalidad);
		}
		/*----------  Editar proveedor  ----------*/
		public function ctrEditarProveedor(){
			if (isset($_POST['txtEditarRepresentanteProveedor']) && isset($_POST['idProveedor'])) {
				if (preg_match('/^[\/\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['txtEditarRepresentanteProveedor'])) {
					$representanteProveedor = $_POST['txtEditarRepresentanteProveedor'];
					$correoProveedor = $_POST['txtEditarCorreoProveedor'];
					$celularProveedor = $_POST['txtEditarCelularProveedor'];
					$idProveedor = $_POST['idProveedor'];
					$editar = new ModeloProveedor();
				 	$respuesta = $editar->mdlEditarProveedor($representanteProveedor, $correoProveedor, $celularProveedor, $idProveedor);
				 	if ($respuesta == 'ok') {
				 		echo mensaje('¡CORRECTO!', '¡El proveedor ha sido editado con exito!', 'success');
				 	}
				 	else{
						echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de editar el proveedor!', 'error');
				 	}
				}else{
					echo mensaje('¡CORREGIR!', '¡No se permiten caracteres especiales en ninguno de los campos!', 'warning');					
				}
			}
		}
	}