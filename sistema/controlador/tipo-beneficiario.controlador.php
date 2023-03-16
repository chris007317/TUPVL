<?php 
	Class ControladorTipoBeneficiario{
		/*----------  Agregar tipo beneficiario  ----------*/
		static public function ctrRegistrarTipoBeneficiario(){
			if (isset($_POST['txtTipoBeneficiario'])) {
				if (preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtTipoBeneficiario"])) {
					$agregar = new ModeloTipoBeneficiario();
				 	$respuesta = $agregar->mdlRegistrarTipoBeneficiario($_POST["txtTipoBeneficiario"], $_POST["txtDescripcionTipoBenef"]);
				 	if ($respuesta > 0) {
						echo mensaje('¡CORRECTO!', '¡El tipo de beneficiario ha sido registrado con exito!', 'success');
				 	}else{
				 		echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar el tipo de beneficiario!', 'error');
				 	}
				}else{
					echo mensaje('CORREGIR!', '¡No se permiten caracteres especiales en ninguno de los campos!', 'warning');
				}
			}
		}
		/*----------  Mostrar tipo beneficiarios  ----------*/
		static public function ctrMostrarTipoBeneficiario(){
			$respuesta = new ModeloTipoBeneficiario();
			return $respuesta->mdlMostrarTipoBeneficiarios();
		}
		/*----------  Editar tipo beneficiarios  ----------*/
		public function ctrEditarTipoBeneficiario(){
			if (isset($_POST['txtEditarDescripcionTipoBenef'])) {
				if (preg_match('/^[\/\=\\&\\;\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtEditarDescripcionTipoBenef"])) {
					$editar = new ModeloTipoBeneficiario();
				 	$respuesta = $editar->mdlEditarTipoBeneficiario($_POST["txtEditarDescripcionTipoBenef"], $_POST['idTipoBeneficiario']);
				 	if ($respuesta) {
				 		echo mensaje('¡CORRECTO!', '¡El tipo de beneficiario ha sido editado con exito!', 'success');
				 	}
				 	else{
						echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de editar el tipo de beneficiario!', 'error');
				 	}
				}else{
					echo mensaje('¡CORREGIR!', '¡No se permiten caracteres especiales en ninguno de los campos!', 'warning');					
				}
			}
		}
		/*----------  buscar tipo beneficiario  ----------*/
		static public function ctrBuscarTipoBeneficiario($idTipoBeneficiario){
			$valor = $idTipoBeneficiario;
			$atributo = 'idTipoBeneficiario';
			$respuesta = new ModeloTipoBeneficiario();
			return $respuesta->mdlMostrarTipoBeneficiario($atributo, $valor);
		}


 	}

