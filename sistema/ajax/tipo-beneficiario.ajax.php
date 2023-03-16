<?php 
	require_once '../controlador/tipo-beneficiario.controlador.php';
	require_once '../modelo/tipo-beneficiario.modelo.php';
	Class AjaxTipoBeneficiario{
		public function ajaxBuscarTipoBeneficiario($idTipoBeneficiario){
			$respuesta = ControladorTipoBeneficiario::ctrBuscarTipoBeneficiario($idTipoBeneficiario);
			echo json_encode($respuesta);

		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarTipoBeneficiario') {
		$propuestas = new AjaxTipoBeneficiario();
		$idTipoBeneficiario = $_POST['idTipoBeneficiario'];
		$propuestas->ajaxBuscarTipoBeneficiario($idTipoBeneficiario);
	}
?>