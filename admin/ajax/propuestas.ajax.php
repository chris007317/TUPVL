<?php 
	require_once "../controlador/propuesta.controlador.php";
	require_once "../controlador/ruta.controlador.php";
	require_once "../modelo/propuesta.modelo.php";
	class AjaxPropuestas{
		/*----------  mostrar propuestas  ----------*/
		public function ajaxBuscaPropuestas($buscarPropuestas){
			$valor = $buscarPropuestas;
			$respuesta = ControladorPropuesta::ctrBuscarPropuestas($valor);
			$ruta = ControladorRuta::ctrRuta();
			$template = ''; 
			foreach ($respuesta as $key => $value) {
			  	$region = ControladorPropuesta::ctrMostrarRegion($value['idDistrito']);
				$template .='<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
			                <div class="card bg-light">
			                  <div class="card-header text-muted border-bottom-0">
			                    <i class="fas fa-medal"></i>'.$value['ruc'].'
		                      </div>
			                  <div class="card-body pt-0">
			                    <div class="row">
			                      <div class="col-7">
			                        <h2 class="lead"><b>'.$value['nombreMunicipalidad'].'</b></h2>
			                        <p class="text-muted text-sm"><b>Dirección: </b> '.$value['direccion'].' </p>
			                        <ul class="ml-4 mb-0 fa-ul text-muted">                        
			                          <li class="small"><span class="fa-li"><i class="fas fa-map-marker-alt"></i></span> Región: '.$region['nombreDepartamento'].', '.$region['nombreProvincia'].', '.$region['nombreDistrito'].'</li>
			                          <li class="small"><span class="fa-li"><i class="fas fa-user-tie"></i></span> Responsable: '.$value['apellidoPaterno'].' '.$value['apellidoMaterno'].', '.$value['nombres'].'</li>
			                        </ul>
			                      </div>
			                      <div class="col-5 text-center">
			                        <img src="'.$ruta.'/sistema/vistas/'.$value['imagenMunicipalidad'].'" alt="" class="img-fluid">
			                      </div>
			                    </div>
			                  </div>
			                  <div class="card-footer">
			                    <div class="text-right">
			                      <button class="btn btn-sm btn-outline-danger mt-1 accion" funcion="rechazarPropuesta" title="Rechazar" idPropuesta="'.$value['idPropuestas'].'">
			                        <i class="fas fa-minus-square"></i> Rechazar
			                      </button>
			                      <button class="btn btn-sm btn-outline-success mt-1 accion" funcion="aceptarPropuesta" title="Aceptar" idPropuesta="'. $value['idPropuestas'].'">
			                        <i class="fas fa-check-square"></i> Aceptar
			                      </button>
			                    </div>
			                  </div>
			                </div>
			              </div>';
			}
		echo $template;
		}
		/*----------  buscar propuesta  ----------*/
		public function ajaxBuscaPropuesta($idPropuesta){
			$valor = $idPropuesta;
			$item = 'idPropuestas';
			$respuesta = ControladorPropuesta::ctrBuscarPropuesta($item, $valor);
			return $respuesta;
		}
		/*----------  registrar municipalidad  ----------*/
		public function ajaxRegistrarMunicipalidad($arrDatos){
			$registrar = ControladorPropuesta::ctrRegistrarMunicipalidad($arrDatos['nombreMunicipalidad'], $arrDatos['imagenMunicipalidad'], $arrDatos['direccion'], $arrDatos['ruc'], $arrDatos['idDistrito']);
			return $registrar;
		}
		/*----------  registrar persona  ----------*/
		public function ajaxRegistrarPersona($arrDatos){
			$registrar = ControladorPropuesta::ctrRegistrarPersona($arrDatos['nombres'], $arrDatos['apellidoMaterno'], $arrDatos['apellidoPaterno'], $arrDatos['dni']);
			return $registrar;
		}
		/*----------  buscar representante  ----------*/
		public function ajaxBuscarPersona($idPersona){
			$valor = $idPersona;
			$item = 'idResponsable';
			$respuesta = ControladorPropuesta::ctrBuscarPersona($item, $valor);
			return $respuesta;
		}
		/*----------  rechazar propuesta  ----------*/
		public function ajaxEditarEstado($idPropuesta){
			$valor = 'FALSE';
			$item = 'estadoMunicipalidad';
			$respuesta = ControladorPropuesta::ctrEditarPropuesta($item, $valor, $idPropuesta);
			if ($respuesta) {
				echo "ok";
			}else{
				echo "error";
			}
		}
		/*----------  registrar persona  ----------*/
		public function ajaxRegistrarUsuario($arrDatos, $idPersona, $idMunicipalidad){
			$usuario = $arrDatos['dni'];
			$contra = crypt($arrDatos["dni"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
			$registrar = ControladorPropuesta::ctrRegistrarUsuario($usuario, $contra, $arrDatos['correo'], $arrDatos['celular'], $idPersona, 1,$idMunicipalidad);
			return $registrar;
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarPropuestas') {
		$propuestas = new AjaxPropuestas();
		$buscarPropuesta = $_POST['buscarPropuesta'];
		$propuestas->ajaxBuscaPropuestas($buscarPropuesta);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'rechazarPropuesta') {
		$idPropuesta = $_POST['idPropuesta'];
		$propuestas = new AjaxPropuestas();
		$propuestas->ajaxEditarEstado($idPropuesta);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'aceptarPropuesta') {
		$idPropuesta = $_POST['idPropuesta'];
		$propuestas = new AjaxPropuestas();
		$datosMuni = $propuestas->ajaxBuscaPropuesta($idPropuesta);
		$idMunicipalidad = $propuestas->ajaxRegistrarMunicipalidad($datosMuni);
		if ($idMunicipalidad == 'existe') {
			echo "existe";
		}else if ($idMunicipalidad > 0) {
			$datosResponsable = $propuestas->ajaxBuscarPersona($datosMuni['idRes']);
			$idPersona = $propuestas->ajaxRegistrarPersona($datosResponsable);
			$correoResponsable = $datosResponsable['correo'];
			$userContra = $datosResponsable['dni'];
			if ($idPersona > 0) {
				$idUsuario = $propuestas->ajaxRegistrarUsuario($datosResponsable, $idPersona, $idMunicipalidad);
				if ($idUsuario > 0) {
					$ruta = ControladorRuta::ctrRuta();
					$header = "From: TUPVL.com <soporte@tupvl.com>\r\n";
					$header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
					$header .= "Mime-Version: 1.0 \r\n";
					$header .= "Content-type: text/html; charset=utf-8\r\n";

					$para = $correoResponsable;
					$asunto = 'Envio de usuario y contraseña';

					$cuerpo = '	<div style="width: 100%; background: #eee; position: relative; font-family: sans-serif; padding-bottom: 40px;">
									<center>
										<img src="'.$ruta.'/vistas/logo.svg" style="padding: 20px; width: 10%;">
									</center>
									<div style="position: relative; margin: auto; width: 600px; background: white; padding: 20px">
										<center>
											<h3 style="font-weight: 100; color: #999">MUNICIPALIDAD REGISTRADA CON EXITO</h3>
											<hr style="border: 1px solid #ccc; width: 80%">
											<h4 style="font-weight: 100; color: #999; padding: 0 20px"><strong>Su usuario es: </strong>'.$userContra.'</h4>
											<h4 style="font-weight: 100; color: #999; padding: 0 20px"><strong>Su contraseña es: </strong>'.$userContra.'</h4>
											<a href="'.$ruta.'/sistema" target="_blank" style="text-decoration: none">
												<div style="line-height: 60px; background: #0aa; width: 60%; color: white">Ingresar al sistema</div>
											</a>
											<h4 style="font-weight: 100; color: #999; padding: 0 20px">Ingrese nuevamente al sitio y recuerde ingresar con los datos mostrados</h4>
											<br>
											<hr style="border: 1px solid #ccc; width: 80%">
											<h5 style="font-weight: 100; color: #999">Se le recomienda cambiar la contraseña una vez tenga acceso al sistema.</h5>
										</center>
									</div>
								</div>';
					mail($para, $asunto, $cuerpo, $header);
					$propuestas->ajaxEditarEstado($idPropuesta);
					return; 
				}else{
					echo "error";
					return;
				}
			}else{
				echo "error";
				return;
			}
		}else{
			echo "error";
			return;
		}
	}

 ?>