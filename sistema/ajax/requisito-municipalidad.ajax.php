<?php 
	require_once '../controlador/requisito-municipalidad.controlador.php';
	require_once '../modelo/requisito-municipalidad.modelo.php';
	session_start();
	Class AjaxRequisitoMunicipalidad{
		/*----------  buscar requisito por municipalidad  ----------*/
		public function ajaxBuscarRequisitoMunicipalidad($idMunicipalidad, $idTipoBeneficiario){
			$respuesta = ControladorRequisitoMunicipalidad::ctrMostrarRequisitoMunicipalidad($idMunicipalidad, $idTipoBeneficiario);
			$template = ''; 
			foreach ($respuesta as $key => $value) {
				if ($value['estado'] == 1) {
					$estado = "<button class='btn btn-warning btn-sm text-white btnActivarRequisito' estadoReMuni='0' idReMuni='".$value['idReMuni']."'>Activo</button>";
				}else{
					$estado = "<button class='btn btn-secondary btn-sm text-white btnActivarRequisito' estadoReMuni='1' idReMuni='".$value['idReMuni']."'>Inactivo</button>";
				}
				$template .='<tr>
							<td>'.($key+1).'</td>
							<td>'.$value['nombreRequisito'].'</td>
							<td>'.$value['descripcionRequisito'].'</td>
							<td>'.$estado.'</td>
	                        <td>
	                            <button class="btn btn-danger btn-sm eliminarRequisitoMunicipalidad" idReMuni="'.$value['idReMuni'].'" title="Eliminar">
	                              <i class="fas fa-backspace"></i>
	                            </button>
	                        </td>
						</tr>';
			}
			echo $template;
		}
		/*----------  editar estado requisito  ----------*/
		public function ajaxEstadoRequisitoMunicipalidad($estado, $idReMuni){
			$item = 'estado';
			$respuesta = ControladorRequisitoMunicipalidad::ctrEditarRequisitoMunicipalidad($item, $estado, $idReMuni);
			echo $respuesta;
		}
		/*----------  editar estado requisito  ----------*/
		public function ajaxEliminarRequisitoMunicipalidad($idReMuni){
			$respuesta = ControladorRequisitoMunicipalidad::ctrEliminarRequisitoMunicipalidad($idReMuni);
			echo $respuesta;
		}

		public function ajaxMostrarTipoBenefRequisitos($idMunicipalidad, $idTipoBeneficiario){
			$respuesta = ControladorRequisitoMunicipalidad::ctrMostrarRequisitoMunicipalidad($idMunicipalidad, $idTipoBeneficiario);
			echo json_encode($respuesta);
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarRequisitos') {
		$idTipoBeneficiario = $_POST['id'];
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$propuestas = new AjaxRequisitoMunicipalidad();
		$propuestas->ajaxBuscarRequisitoMunicipalidad($idMunicipalidad, $idTipoBeneficiario);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarEstado') {
		$idReMuni = $_POST['idReMuni'];
		$estado = $_POST['estadoReMuni'];
		$propuestas = new AjaxRequisitoMunicipalidad();
		$propuestas->ajaxEstadoRequisitoMunicipalidad($estado, $idReMuni);
	}
	
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'elimarRequisitoMuni') {
		$idReMuni = $_POST['idReMuni'];
		$propuestas = new AjaxRequisitoMunicipalidad();
		$propuestas->ajaxEliminarRequisitoMunicipalidad($idReMuni);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarTipoBenefRequisitos') {
		$idTipoBeneficiario = $_POST['idTipoBeneficiario'];
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$propuestas = new AjaxRequisitoMunicipalidad();
		$propuestas->ajaxMostrarTipoBenefRequisitos($idMunicipalidad, $idTipoBeneficiario);
	}
?>