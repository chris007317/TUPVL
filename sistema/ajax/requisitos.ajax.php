<?php 
	require_once '../controlador/requisito.controlador.php';
	require_once '../modelo/requisitos.modelo.php';
	Class AjaxRequisitos{
		public function ajaxBuscaRequisito($idRequisito){
			$respuesta = ControladorRequisitos::ctrBuscarRequisito($idRequisito);
			echo json_encode($respuesta);

		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarRequisito') {
		$propuestas = new AjaxRequisitos();
		$idRequisito = $_POST['idRequisito'];
		$propuestas->ajaxBuscaRequisito($idRequisito);
	}
?>