<?php 
	require_once '../controlador/beneficiario.controlador.php';
	require_once '../modelo/beneficiario.modelo.php';

	require_once '../controlador/postulante.controlador.php';
	require_once '../modelo/postulante.modelo.php';

	require_once '../controlador/socio.controlador.php';
	require_once '../modelo/socio.modelo.php';

	require_once '../helper/funciones.php';
	session_start();
	Class AjaxConsultas{
		/*----------  editar estado proveedor  ----------*/
		public function mostrarConsulta(){
			if (isset($_POST['cmbTipoConsulta']) && !empty($_POST['cmbTipoConsulta']) && isset($_POST['txtDniPersona']) && !empty($_POST['txtDniPersona'])) {
				$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
				$respuesta = '';
				$tipo = $_POST['cmbTipoConsulta'];
				$postulante = ControladorPostulante::ctrMostrarPostulante('dniPersona', $_POST['txtDniPersona']);			
				if ($tipo == 1) {
					$respuesta = ControladorBeneficiario::ctrConsultaBeneficiario($idMunicipalidad, $_POST['txtDniPersona']);		
				}else if ($tipo == 2) {
					$respuesta = ControladorPostulante::ctrConsultaPostulante($idMunicipalidad, $_POST['txtDniPersona']);
				}
				$persona = '<h2>No se encontraron resultados</h2>';
				$template = '';
				if (!empty($respuesta && !empty($postulante))) {
					$persona = $postulante['nombrePersona'].' '.$postulante['apellidoPaternoPersona'].' '.$postulante['apellidoMaternoPersona'];
					foreach ($respuesta as $key => $value) {
						$socio = ControladorSocio::ctrMostrarSocio('idSocio', $value['socio'], $idMunicipalidad);
						$estado = '';
						$est = 0;
						if ($tipo == 1) {
							$estado = "<h5><span class='".$value['estilo']."''>".$value['nombreEstadoBeneficiario']."</span></h5>";
						}else if($tipo == 2){
							$est = $value['estadoInscripcion'];
							if ($est == 0) {
								$estado = "<h5><span class='badge badge-danger'>Rechazado</span></h5>";
							}else if ($est == 1) {
								$estado = "<h5><span class='badge badge-primary'>Recibido</span></h5>";
							}else if($est == 2){
								$estado = "<h5><span class='badge badge-success'>Aceptado</span></h5>";
							}
						}
						$tipoBenef = mb_strtoupper($value['nombreTipoBeneficiario'], 'UTF-8');
						$comite = mb_strtoupper($value['nombreComite'], 'UTF-8');
						$fecha = "<h5><span class='badge badge-info'>".$value['fecha']."</span></h5>";
						$template .='<tr>
								<td>'.($key+1).'</td>
								<td>'.$value['nombreMunicipalidad'].'</td>
								<td>'.$comite.'</td>
								<td>'.$tipoBenef.'</td>
								<td>'.$socio['nombrePersona'].' '.$socio['apellidoPaternoPersona'].' '.$socio['apellidoMaternoPersona'].'</td>
								<td>'.$fecha.'</td>
								<td>'.$estado.'</td>
							</tr>';
					}
					date_default_timezone_set('America/Lima');
					$edad = calcularEdad($postulante['fechaNacimiento']);
					$persona = '<div class="card card-widget  p-0" >
					                  <div class="widget-user-header bg-warning p-2">
					                    <!-- /.widget-user-image -->
					                    <h4 class="widget-user-desc">'.$persona.'</h4>
					                  </div>
					                  <div class="card-footer p-0">
					                    <ul class="nav flex-column">
					                      <li class="nav-item">
					                        <strong class="nav-link ">
					                          Fecha de nacimiento: <span class="float-right badge bg-primary">'.$postulante['fechaNacimiento'].'</span>
					                        </strong>
					                      </li>
					                      <li class="nav-item">
					                        <strong class="nav-link">
					                          Sexo: <span class="float-right badge bg-info">'.$postulante['sexoPostulante'].'</span>
					                        </strong>
					                      </li>
					                      <li class="nav-item">
					                        <strong class="nav-link">
					                          Edad: <span class="float-right badge bg-success">'.$edad.'</span>
					                        </strong>
					                      </li>
					                    </ul>
					                  </div>
					                </div>';
				}
				
				$respuesta = array('persona' => $persona, 'template' => $template);
				echo json_encode($respuesta);
			}			
		}

	}

	$planes = new AjaxConsultas();
	$planes->mostrarConsulta();
 ?> 