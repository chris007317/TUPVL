<?php 
	Class ControladorComite{
		/*----------  Nueva comite  ----------*/
		static public function ctrAgregarComite(){
			if (isset($_POST['cmbLocalidadComite']) && isset($_POST['txtNombreComite']) && isset($_POST['txtDireccionComite']) &&
				!empty($_POST['cmbLocalidadComite']) && !empty($_POST['txtNombreComite']) && !empty($_POST['txtDireccionComite'])) {
				$direccion = trim($_POST['txtDireccionComite']);
				$nombreComite = trim($_POST['txtNombreComite']);
				if (preg_match('/^[0-9]+$/', $_POST['txtNumeroComite']) &&
					preg_match('/^[\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombreComite) && 
					preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $direccion) &&
					(preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtDescripcionComite"]) || empty($_POST['txtDescripcionComite']))){
					$idLocalidad = $_POST['cmbLocalidadComite'];
					$numero = intval($_POST['txtNumeroComite']);
					$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
					$descripcionComite = $_POST['txtDescripcionComite'];
					$agregar = new ModeloComite();
				 	$respuesta = $agregar->mdlAgregarComite($nombreComite, $direccion, $numero, $descripcionComite, $idLocalidad, $idMunicipalidad);
				 	if($respuesta == 'existe'){
			 			echo mensaje('¡ADVERTENCIA!', '¡El comité ya existe!', 'warning');
				 	}else if($respuesta > 0) {
						echo mensaje('¡CORRECTO!', '¡Los datos han sido registrados con exito!', 'success');
				 	}else{
				 		echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar los datos!', 'error');
				 	}
				}else{
					echo mensaje('¡ERROR!', '¡Los datos no deben contener caracteres especiales!', 'error');	
				}
			}
		}
		/*----------  Mostrar Comités  ----------*/
		static public function ctrMostrarComites($idMunicipalidad){
			$respuesta = new ModeloComite();
			return $respuesta->mdlMostrarComites($idMunicipalidad);
		}
		/*----------  mostrar comités por localidades  ----------*/
		static public function ctrMostrarComitesLocalidad($idMunicipalidad, $idLocalidad){
			$respuesta = new ModeloComite();
			return $respuesta->mdlMostrarComitesLocalidad($idMunicipalidad, $idLocalidad);
		}
		/*----------  editar un solo campo de un comite  ----------*/
		static public function ctrEditarCampoComite($item, $valor, $idComite){
			$respuesta = new ModeloComite();
			$editar = $respuesta->mdlEditarCampoComite($item, $valor, $idComite);	
			if($editar){
				return 'ok';
			}
		}
		/*----------  Mostrar un solo comite  ----------*/
		static public function ctrMostrarComite($idComite){
			$respuesta = new ModeloComite();
			return $respuesta->mdlMostrarComite($idComite);
		}
		public function ctrEditarComite(){
			if (isset($_POST['cmbLocalidadComite']) && isset($_POST['txtNombreComite']) && isset($_POST['txtDireccionComite']) && isset($_POST['idComite']) &&
				!empty($_POST['cmbLocalidadComite']) && !empty($_POST['txtNombreComite']) && !empty($_POST['txtDireccionComite']) && !empty($_POST['idComite'])) {
				$direccion = trim($_POST['txtDireccionComite']);
				$nombreComite = trim($_POST['txtNombreComite']);
				if (preg_match('/^[0-9]+$/', $_POST['txtNumeroComite']) &&
					preg_match('/^[\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombreComite) && 
					preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $direccion) &&
					(preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtDescripcionComite"]) || empty($_POST['txtDescripcionComite']))){
					$idLocalidad = $_POST['cmbLocalidadComite'];
					$numero = intval($_POST['txtNumeroComite']);
					$idComite = intval($_POST['idComite']); 
					$descripcionComite = $_POST['txtDescripcionComite'];
					$agregar = new ModeloComite();
				 	$respuesta = $agregar->mdlEditarComite($nombreComite, $direccion, $numero, $descripcionComite, $idLocalidad, $idComite);
				 	if ($respuesta == 'ok') {
				 		echo mensaje('¡CORRECTO!', '¡El comité fue editado con exito!', 'success');
				 	}else{
						echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de editar el comité!', 'error');
				 	}
				}else{
					echo mensaje('¡CORREGIR!', '¡No se permiten caracteres especiales en ninguno de los campos!', 'warning');					
				}
			}
		}
		/*----------  Mostrar Comités  ----------*/
		static public function ctrContarComite($idMunicipalidad){
			$respuesta = new ModeloComite();
			return $respuesta->mdlContarComites($idMunicipalidad);
		}
		/*----------  mostrar cmb comites por localidad  ----------*/
		static public function ctrMostrarComitesLocal($idMunicipalidad, $idLocalidad){
			$respuesta = new ModeloComite();
			return $respuesta->mdlMostrarComitesLocal($idMunicipalidad, $idLocalidad);
		}
		/*----------  contar todos los comités  ----------*/
		static public function ctrTotalComites($idMunicipalidad, $estado){
			$respuesta = new ModeloComite();
			return $respuesta->mdlTotalComites($idMunicipalidad, $estado);
		}
	} 
