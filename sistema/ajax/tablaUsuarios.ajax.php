<?php 
	require_once '../controlador/usuario.controlador.php';
	require_once '../modelo/usuario.modelo.php';
	session_start();
	Class TablaUsuarios{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
			$usuarios = ControladorUsuario::ctrMostrarUsuarios($idMunicipalidad);
			if (count($usuarios) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				
				foreach ($usuarios as $key => $value) {
					$img = "<div class='align-content-center w-100 text-center'><img class='img-circle elevation-2 w-50' src='".$value['fotoUsuario']."' alt='Imagen usuario'></div>";
					if ($value['idTipoUsuario'] != 1) {
						$acciones = "<div class='btn-group'><button class='btn btn-danger btn-sm editarUsuario' title='Editar usuario' idUsuario='".$value['idUsuario']."' data-toggle='modal' data-target='#editarUsuario'><i class='fas fa-user-edit'></i></button><button class='btn btn-primary btn-sm editarImg' title='Cambiar imagen' idUsuario='".$value['idUsuario']."' data-toggle='modal' data-target='#editarImg'><i class='fas fa-image'></i></button><button class='btn btn-success btn-sm cambiarContra' title='Cambiar contraseña' idUsuario='".$value['idUsuario']."' data-toggle='modal' data-target='#cambiarContra'><i class='fas fa-key'></i></button>";
						$nombreTipoUsuario = "<div class='text-center'><h5><span class='badge badge-info'>".$value['nombreTipoUsuario']."</span></h5></div>";
						if ($value['estadoUsuario'] == 1) {
							$estado = "<div class='text-center'><button class='btn btn-warning btn-sm text-white btnActivarUsuario' estadoUsuario='0' idUsuario='".$value['idUsuario']."'>Activo</button></div>";
						}else{
							$estado = "<div class='text-center'><button class='btn btn-secondary btn-sm text-white btnActivarUsuario' estadoUsuario='1' idUsuario='".$value['idUsuario']."'>Inactivo</button></div>";
						}
					}else{	
						$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm editarImg' title='Cambiar imagen' idUsuario='".$value['idUsuario']."' data-toggle='modal' data-target='#editarImg'><i class='fas fa-image'></i></button><button class='btn btn-success btn-sm cambiarContra' title='Cambiar contraseña' idUsuario='".$value['idUsuario']."' data-toggle='modal' data-target='#cambiarContra'><i class='fas fa-key'></i></button>";
						$estado = "<div class='text-center'><button class='btn btn-info btn-sm text-white'>Activo</button></div>";
						$nombreTipoUsuario = "<div class='text-center'><h5><span class='badge badge-danger'>".$value['nombreTipoUsuario']."</span></h5></div>";
					}
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['nombreUsuario'].'",
							"'.$value['correoUsuario'].'",
							"'.$value['nombrePersona'].' '.$value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].'",
							"'.$value['celularUsuario'].'",
							"'.$nombreTipoUsuario.'",
							"'.$img.'",
							"'.$estado.'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				echo $datosJson;
			}
		}
	}

	$planes = new TablaUsuarios();
	$planes->mostrarTabla();