<?php 
	Class ControladorLocalidad{
		/*----------  Mostrar tipo de localidad  ----------*/
		static public function ctrMostrarTipoLocalidad(){
			$respuesta = new ModeloLocalidad();
			return $respuesta->mdlMostrarTipoLocalidad();
		}
		/*----------  Mostrar localidades por municipalidad  ----------*/
		static public function ctrMostrarLocalidades($idMunicipalidad){
			$respuesta = new ModeloLocalidad();
			return $respuesta->mdlMostrarLocalidades($idMunicipalidad);
		}
		/*----------  Agregar localidad  ----------*/
		static public function ctrAgregarlocalidad(){
			if (isset($_POST['txtAgregarLocalidad'])) {
				$idTipoLocalidad = intval($_POST['cmbAgregarLocalidad']);
				$idMunicipalidad = intval($_SESSION['idMunicipalidadPvl']);
				if (preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtAgregarLocalidad"])) {
					$agregar = new ModeloLocalidad();
				 	$respuesta = $agregar->mdlAgregarLocalidad($_POST["txtAgregarLocalidad"], $idMunicipalidad, $idTipoLocalidad);
				 	if ($respuesta > 0) {
				 		echo mensaje('¡CORRECTO!', '¡La localidad fue agreda con exito!', 'success');
				 	}else{
				 		echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar la localidad!', 'error');
				 	}
				}else{
					echo mensaje('CORREGIR!', '¡No se permiten caracteres especiales en ninguno de los campos!', 'warning');
				}
			}
		}
		/*----------  editar estado localidad  ----------*/
		static public function ctrEditarLocalidad($item, $valor, $idLocalidad){
			$respuesta = new ModeloLocalidad();
			$editar = $respuesta->mdlEditarLocalidad($item, $valor, $idLocalidad);	
			if($editar){
				return 'ok';
			}
		}
		/*----------  buscar localidad  ----------*/
		static public function ctrMostrarLocalidad($idLocalidad){
			$respuesta = new ModeloLocalidad();
			return $respuesta->mdlMostrarLocalidad($idLocalidad);
		}
		/*----------  editar localidad municipalidad  ----------*/
		static public function ctrActualizarLocalidad($idLocalidad, $nombreLocalidad,$idTipoLocalidad){
			$respuesta = new ModeloLocalidad();
			$editar = $respuesta->mdlActualizarLocalidad($idLocalidad, $nombreLocalidad, $idTipoLocalidad);	
			if($editar>0){
				$editar = 'ok';
			}
			return $editar;
		}		
		/*----------  Mostrar localidades por municipalidad  ----------*/
		static public function ctrMostrarLocalidadesActivas($idMunicipalidad){
			$respuesta = new ModeloLocalidad();
			return $respuesta->mdlMostrarLocalidadesActivas($idMunicipalidad);
		}
	}