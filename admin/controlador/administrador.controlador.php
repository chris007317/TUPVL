<?php 	
	Class ControladorAdminsitrador{
		/*----------  Ingreso de administradores  ----------*/
		public function ctrIngresoAdmin(){
			if (isset($_POST['txtUsuarioAdmin'])) {
				if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['txtUsuarioAdmin']) && preg_match('/^[a-zA-Z0-9]+$/', $_POST['txtContraAdmin'])) {
					$encriptarPassword = crypt($_POST["txtContraAdmin"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
					$valor = $_POST['txtUsuarioAdmin'];
					$atributo = 'nombre';
					$admin = new ModeloAdministrador();
					$respuesta = $admin->mdlMostrarAdministrador($atributo, $valor);
					if (!$respuesta) {
						echo '<div class="alert alert-danger mt-3 small">Error: Usuario y/o contraseña incorrectos</div>';	
					}else if ($respuesta['nombre'] == $_POST['txtUsuarioAdmin'] && $respuesta['contra'] == $encriptarPassword) {
						if ($respuesta['estado'] == TRUE) {
							$_SESSION['validarInicioAdmin'] = 'ok';
							$_SESSION['idAdmin'] = $respuesta['idAdministrador'];
							echo '<script>
								window.location = "'.$_SERVER['REQUEST_URI'].'"; 
							</script>';
						}else{
							echo '<div class="alert alert-danger mt-3 small">Error el usuario esta desactivado</div>';	
						}
					}else{
						echo '<div class="alert alert-danger mt-3 small">Error: Usuario y/o contraseña incorrectos</div>';	
					}
				}else{
					echo '<div class="alert alert-danger mt-3 small">Error: No se permiten caracteres especiales</div>';
				}
			}
		}
		/*----------  Mostrar datos administrador  ----------*/
		static public function ctrMostrarAdministrador($idAdministrador){
			$atributo = 'idAdministrador';
			$admin = new ModeloAdministrador();
			$respuesta = $admin->mdlMostrarAdministrador($atributo, $idAdministrador);
			return $respuesta;
		} 
		
	}
