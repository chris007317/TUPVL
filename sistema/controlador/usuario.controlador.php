<?php 	
	Class ControladorUsuario{
		/*----------  Ingreso de administradores  ----------*/
		public function ctrIngresoUsuario(){
			if (isset($_POST['txtUsuarioPvl'])) {
				if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['txtUsuarioPvl']) && preg_match('/^[a-zA-Z0-9]+$/', $_POST['txtContraPvl'])) {
					$encriptarPassword = crypt($_POST["txtContraPvl"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
					$valor = $_POST['txtUsuarioPvl'];
					$atributo = 'nombreUsuario';
					$ingresar = new ModeloUsuario();
					$respuesta  = $ingresar->mdlMostrarUsuario($atributo, $valor);
					if (!$respuesta) {
						echo '<div class="alert alert-danger mt-3 small">Error: Usuario y/o contraseña incorrectos</div>';	
					}else if ($respuesta['nombreUsuario'] == $_POST['txtUsuarioPvl'] && $respuesta['contraUsuario'] == $encriptarPassword) {
						if ($respuesta['estadoUsuario'] == TRUE) {
							$_SESSION['validarUsuarioPvl'] = 'ok';
							$_SESSION['idUsuarioPvl'] = $respuesta['idUsuario'];
							$_SESSION['idMunicipalidadPvl'] = $respuesta['idMunicipalidadUsuario'];
							echo '<script>
								window.location = "'.$_SERVER['REQUEST_URI'].'"; 
							</script>';
						}else{
							echo '<div class="pd-top-10">Error el usuario esta desactivado</div>';	
						}
					}else{
						echo '<div class="pd-top-10">Error: Usuario y/o contraseña incorrectos</div>';	
					}
				}else{
					echo '<div class="pd-top-10">Error: No se permiten caracteres especiales</div>';
				}
			}
		}
		/*----------  Mostrar datos completos del usuario  ----------*/
		static public function ctrMostrarDatosUsuario($idUsuario){
			$respuesta = new ModeloUsuario();
			return $respuesta->mdlMostrarDatosUsuario($idUsuario);
		}
		/*----------  Mostrar datos completos del usuario  ----------*/
		static public function ctrMostrarUsuario($item, $valor){
			$respuesta = new ModeloUsuario();
			return $respuesta->mdlVerUsuario($item, $valor);
		}
		/*----------  mostrar los tipos de usuarios  ----------*/
		static public function ctrMostrarTipoUsuario(){
			$respuesta = new ModeloUsuario();
			return $respuesta->mdlMostrarTipoUsuario();
		} 
		/*----------  Agregar nuevo presidente  ----------*/
		public function ctrAgregarUsuario(){
			if (isset($_POST['txtDniUsuario']) && isset($_POST['txtApellidoPaterno']) &&
				isset($_POST['txtApellidoMaterno']) && isset($_POST['txtNombreUsuario']) &&
				isset($_POST['txtUsuario']) && !empty($_POST['txtUsuario']) &&
				isset($_POST['cmbPerfil']) && !empty($_POST['cmbPerfil']) &&
				isset($_POST['txtContraUsuario']) && !empty($_POST['txtContraUsuario']) &&
				!empty($_POST['txtDniUsuario']) && !empty($_POST['txtApellidoPaterno']) &&
				!empty($_POST['txtApellidoMaterno']) && !empty($_POST['txtNombreUsuario']) 
				
			) {
				$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
				$apellidoPaterno = trim($_POST['txtApellidoPaterno']);
				$apellidoMaterno = trim($_POST['txtApellidoMaterno']);
				$nombres = trim($_POST['txtNombreUsuario']);
				$nombreUsuario = trim($_POST['txtUsuario']);
				$contraUsuario = crypt($_POST['txtContraUsuario'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
				$idTipoUsuario = $_POST['cmbPerfil'];
				$dni = trim($_POST['txtDniUsuario']);
				$verUsuario = new ModeloUsuario();
				$usuario = $verUsuario->mdlVerUsuario('dniPersona', $dni);
				if (!empty($usuario)) {
					echo mensaje('Advertencia!', '¡El usuario ya se encuentra registrado!', 'warning');
					exit();
				}else if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoPaterno) &&
					preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoMaterno) &&
					preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombres) && 
					preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombreUsuario) &&
					preg_match('/^[0-9]+$/', $dni) && (preg_match('/^[0-9]+$/', $_POST['txtCelularUsuario']) || empty($_POST['txtCelularUsuario'])) && 
					(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['txtCorreoUsuario']) || empty($_POST['txtCorreoUsuario'])) 
				){
					$ruta = '';
					$directorio = "vistas/img/usuarios";
					if (isset($_FILES['flImgUsuario']['tmp_name']) && !empty($_FILES['flImgUsuario']['tmp_name'])) {
						list($ancho, $alto) = getimagesize($_FILES['flImgUsuario']['tmp_name']);
	   					$nuevoAncho = 160;
						$nuevoAlto = 160; 
						$nombreImg = uniqid().'-'.$dni.'-'.$idMunicipalidad;
						if ($_FILES['flImgUsuario']['type'] == "image/jpeg") {
							$ruta = $directorio."/".$nombreImg.".jpg";
							$origen = imagecreatefromjpeg($_FILES['flImgUsuario']['tmp_name']); 
							$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
							imagejpeg($destino, $ruta);
						}else if($_FILES['flImgUsuario']['type'] == "image/png"){
							$ruta = $directorio."/".$nombreImg.".png";
							$origen = imagecreatefrompng($_FILES['flImgUsuario']['tmp_name']);
							$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
							imagealphablending($destino, FALSE);
							imagesavealpha($destino, TRUE);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
							imagepng($destino, $ruta);
						}else{
							echo mensaje('¡ERROR!', '¡No se permiten formatos diferentes a JPG y/o PNG!', 'error');
							return;
						}
					}else{
						$ruta = $directorio.'/admin.png';
					}
					if (empty($_POST['idPersona'])) {
						$agregarPersona = new ModeloPersona();
						$idPersona = $agregarPersona->mdlRegistrarPersona($nombres, $apellidoMaterno, $apellidoPaterno, $dni);
						if ($idPersona < 1) {
							echo mensaje('¡ERROR!', '¡Ocurrio un error al registrar, vuelva a intentar', 'error');
							exit();
						}
					}else{
						$idPersona = $_POST['idPersona'];
					}
					$nuevoUsuario = new ModeloUsuario();
					$idUsuario = $nuevoUsuario->mdlAgregarUsuario($nombreUsuario, $contraUsuario, $_POST['txtCorreoUsuario'], $ruta, $_POST['txtCelularUsuario'], $idPersona, $idTipoUsuario, $idMunicipalidad);
 						if ($idUsuario > 0) {
 							echo mensajeRecarga('¡CORRECTO!', 'El usuario fue registrado con exito', 'success');
 						}else if($idUsuario == 'existe'){
 							echo mensaje('Advertencia!', '¡El nombre de usuario ya existe! vuelva a intentar', 'warning');
 						}else{
 							echo mensaje('¡ERROR!', '¡Ocurrio un error al registrar, vuelva a intentar', 'error');
 						}
					
				}else{
					echo mensaje('¡ERROR!', '¡no se permiten caracteres especiales en ningun campo', 'error');
					
				}

			}
		}
		/*----------  mostrar todos los usuarios  ----------*/
		static public function ctrMostrarUsuarios($idMunicipalidad){
			$respuesta = new ModeloUsuario();
			return $respuesta->mdlMostrarUsuarios($idMunicipalidad);
		}
		/*----------  editar usuario  ----------*/
				/*----------  Agregar nuevo presidente  ----------*/
		public function ctrEditarUsuario(){
			if (isset($_POST['txtEditarUsuario']) && isset($_POST['cmbEditarPerfil']) && !empty($_POST['cmbEditarPerfil']) && !empty($_POST['txtEditarUsuario']) && isset($_POST['idUsuario']) && !empty($_POST['idUsuario'])
			) {
				$nombreUsuario = trim($_POST['txtEditarUsuario']);
				$idTipoUsuario = $_POST['cmbEditarPerfil'];
				$idUsuario = $_POST['idUsuario'];
				$verUsuario = new ModeloUsuario();
				$usuario = $verUsuario->mdlVerUsuarioId('nombreUsuario', $nombreUsuario, $idUsuario);
				if (!empty($usuario)) {
					return 'existe';
					
				}else if (preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombreUsuario) && 
					(preg_match('/^[0-9]+$/', $_POST['txtEditarCeluar']) || empty($_POST['txtEditarCeluar'])) && 
					(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['txtEditarCorreo']) || empty($_POST['txtEditarCorreo'])) 
				){
					$editarUsuario = new ModeloUsuario();
					$respuesta = $editarUsuario->mdlEditarUsuario($nombreUsuario, $_POST['txtEditarCorreo'], $_POST['txtEditarCeluar'], $idTipoUsuario, $idUsuario);
 						if ($respuesta) {
 							return 'ok';
 						}else{
 							return 'error';
 						}
				}else{
					return 'novalido';					
				}

			}
		}

		public function ctrEditarImg(){
			if (isset($_POST['idPersonaImg']) && !empty($_POST['idPersonaImg']) && isset($_POST['imgActual']) && !empty($_POST['imgActual'])) {
				$idUsuario = $_POST['idPersonaImg'];
				$directorio = "../vistas/img/usuarios";	
				if (isset($_FILES['flEditarImg']['tmp_name']) && !empty($_FILES['flEditarImg']['tmp_name'])) {
					list($ancho, $alto) = getimagesize($_FILES['flEditarImg']['tmp_name']);
   					$nuevoAncho = 180;
					$nuevoAlto = 180; 
					$nombreImg = uniqid().'-'.$idUsuario;
					if ($_FILES['flEditarImg']['type'] == "image/jpeg") {
						$ruta1 = $directorio."/".$nombreImg.".jpg";
						$ruta = 'vistas/img/usuarios/'.$nombreImg.'.jpg';
						$origen = imagecreatefromjpeg($_FILES['flEditarImg']['tmp_name']); 
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagejpeg($destino, $ruta1);
					}else if($_FILES['flEditarImg']['type'] == "image/png"){
						$ruta1 = $directorio."/".$nombreImg.".png";
						$ruta = 'vistas/img/usuarios/'.$nombreImg.'.png';
						$origen = imagecreatefrompng($_FILES['flEditarImg']['tmp_name']);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagealphablending($destino, FALSE);
						imagesavealpha($destino, TRUE);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagepng($destino, $ruta1);
					}else{
						echo "novalido";
						return;
					}
				}
				$editarUsuario = new ModeloUsuario();
				$respuesta = $editarUsuario->mdlEditarImg($idUsuario, $ruta);
				if ($respuesta) {
					if ($_POST['imgActual'] != 'vistas/img/usuarios/admin.png') {
						unlink('../'.$_POST['imgActual']);
					}
					echo 'ok';
					return;
				}else{
					echo 'error';
					return;
				}
			}
		}

		public static function ctrEditarContra(){
			if (isset($_POST['txtContraUsuario1']) && isset($_POST['txtContraUsuario2']) && !empty($_POST['txtContraUsuario2']) && !empty($_POST['txtContraUsuario1']) && isset($_POST['idUsuarioContra']) && !empty($_POST['idUsuarioContra'])
			) {
				$contra1 = $_POST['txtContraUsuario1'];
				$contra2 = $_POST['txtContraUsuario2'];
				$idUsuario = $_POST['idUsuarioContra'];
				if ($contra1 == $contra2) {
					$contraUsuario = crypt($contra1, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
					$editarUsuario = new ModeloUsuario();
					$respuesta = $editarUsuario->mdlEditarContra($idUsuario, $contraUsuario);
					if ($respuesta) {
						echo 'ok';
						return;
					}else{
						echo 'error';
						return;
					}
				}else{
					echo "novalido";
					return;
				}
			}
		}

		public static function ctreditarEstado($idUsuario, $estado){
			$editarUsuario = new ModeloUsuario();
			$respuesta = $editarUsuario->mdlEditarEstado($idUsuario, $estado);
			if($respuesta){
				return 'ok';
			}
		}
	}
