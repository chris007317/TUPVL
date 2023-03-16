<?php 
	Class ControladorRequisitos{
		/*----------  Agregar requisitos  ----------*/
		static public function ctrRegistrarRequisitos(){
			if (isset($_POST['txtRequsito'])) {
				if (preg_match('/^[\/\;\\_\\"\\?\\¿\\!\\¡\\:\\,\\.\\$\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtRequsito"])) {
					$agregar = new ModeloRequsitos();
				 	$respuesta = $agregar->mdlRegistrarRequisito($_POST["txtRequsito"], $_POST["txtDescripcionRequisito"]);
				 	if ($respuesta > 0) {
						echo mensaje('¡CORRECTO!', '¡El requisito ha sido registrado con exito!', 'success');
				 	}else{
				 		echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar el requisito!', 'error');
				 	}
				}else{
					echo mensaje('CORREGIR!', '¡No se permiten caracteres especiales en ninguno de los campos!', 'warning');
				}
			}
		}
		/*----------  Mostrar requisitos  ----------*/
		static public function ctrMostrarRequisitos(){
			$respuesta = new ModeloRequsitos();
			return $respuesta->mdlMostrarRequisitos();
		}
		/*----------  Editar requisito  ----------*/
		public function ctrEditarRequisito(){
			if (isset($_POST['txtEditarDescripcionReq'])) {
				if (preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtEditarDescripcionReq"])) {
					$editar = new ModeloRequsitos();
				 	$respuesta = $editar->mdlEditarRequisito($_POST["txtEditarDescripcionReq"], $_POST['idRequisitos']);
				 	if ($respuesta) {
				 		echo mensaje('¡CORRECTO!', '¡El requisito ha sido editado con exito!', 'success');
				 	}
				 	else{
						echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de editar el requisito!', 'error');
				 	}
				}else{
					echo mensaje('¡CORREGIR!', '¡No se permiten caracteres especiales en ninguno de los campos!', 'warning');					
				}
			}
		}
		static public function ctrBuscarRequisito($idRequisito){
			$valor = $idRequisito;
			$atributo = 'idRequisito';
			$respuesta = new ModeloRequsitos();
			return $respuesta->mdlMostrarRequisito($atributo, $valor);
		}


 	}

