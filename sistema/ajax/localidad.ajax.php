<?php 
	require_once '../controlador/localidadad.controlador.php';
	require_once '../modelo/localidad.modelo.php';

	require_once '../controlador/beneficiario.controlador.php';
	require_once '../modelo/beneficiario.modelo.php';

	session_start();
	Class AjaxLocalidad{
		/*----------  buscar localidades por municipalidad  ----------*/
		public function ajaxLocalidadMunicipalidad($idMunicipalidad){
			$respuesta = ControladorLocalidad::ctrMostrarLocalidades($idMunicipalidad);
			$template = ''; 
			foreach ($respuesta as $key => $value) {
				if ($value['estadoLocalidad'] == 1) {
					$estado = "<button class='btn btn-warning btn-sm text-white btnActivarLocalidad' estadoLocalidad='0' idLocalidad='".$value['idLocalidad']."'>Activo</button>";
				}else{
					$estado = "<button class='btn btn-secondary btn-sm text-white btnActivarLocalidad' estadoLocalidad='1' idLocalidad='".$value['idLocalidad']."'>Inactivo</button>";
				}
				$template .='<tr>
							<td>'.($key+1).'</td>
							<td>'.$value['nombreLocalidad'].'</td>
							<td>'.$value['nombreTipoLocalidad'].'</td>
							<td>'.$estado.'</td>
	                        <td>
	                            <button class="btn btn-success btn-sm editarLocalidad" idLocalidad="'.$value['idLocalidad'].'" title="editar" data-toggle="modal" data-target="#editarLocalidad">
	                              <i class="fas fa-pencil-alt"></i>
	                            </button>
	                        </td>
						</tr>';
			} 
			echo $template;
		}
		/*----------  editar estado localidad  ----------*/
		public function ajaxEstadoLocalidadMunicipalidad($estado, $idLocalidad){
			$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
			$validar = ControladorBeneficiario::ctrVerPeriodos($idMunicipalidad, 0);
			if ($validar['total'] == 0) {
				$item = 'estadoLocalidad';
				$respuesta = ControladorLocalidad::ctrEditarLocalidad($item, $estado, $idLocalidad);				
				echo $respuesta;
			}else{
				echo 'no';
			}
		}
		/*----------  mostrar localidad  ----------*/
		public function ajaxMostrarLocalidad($idLocalidad){
			$respuesta = ControladorLocalidad::ctrMostrarLocalidad($idLocalidad);
			echo json_encode($respuesta);
		}
		/*----------  editar localidad municipalidad  ----------*/
		public function ajaxEditarLocalidadMunicipalidad($idLocalidad, $nombreLocalidad, $idTipoLocalidad){
			$respuesta = ControladorLocalidad::ctrActualizarLocalidad($idLocalidad, $nombreLocalidad, $idTipoLocalidad);
			echo $respuesta;
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarLocalidad') {
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$propuestas = new AjaxLocalidad();
		$propuestas->ajaxLocalidadMunicipalidad($idMunicipalidad);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarEstadoLocalidad') {
		$idLocalidad = $_POST['idLocalidad'];
		$estado = $_POST['estadoLocalidad'];
		$propuestas = new AjaxLocalidad();
		$propuestas->ajaxEstadoLocalidadMunicipalidad($estado, $idLocalidad);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarLocalidadMuni') {
		$idLocalidad = $_POST['idLocalidad'];
		$propuestas = new AjaxLocalidad();
		$propuestas->ajaxMostrarLocalidad($idLocalidad);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarLocalidad') {
		if (preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtEditarLocalidad"])) {
			$idLocalidad = $_POST['idLocalidad'];
			$idTipoLocalidad = $_POST['cmbEditarLocalidad'];
			$nombreLocalidad = $_POST['txtEditarLocalidad'];
			$propuestas = new AjaxLocalidad();
			$propuestas->ajaxEditarLocalidadMunicipalidad($idLocalidad, $nombreLocalidad, $idTipoLocalidad);	
		}else{
			echo "novalido";
		}
	}
?>