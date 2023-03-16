<?php 
	require_once '../controlador/proveedor.controlador.php';
	require_once '../modelo/proveedor.modelo.php';
	session_start();
	Class AjaxProveedor{
		/*----------  editar estado proveedor  ----------*/
		public function ajaxEstadoProveedor($estado, $idProveedor){
			$item = 'estadoProveedor';
			$respuesta = ControladorProveedor::ctrEditarCampoProveedor($item, $estado, $idProveedor);
			echo $respuesta;
		}
		/*----------  Mostrar dato de un solo proveedor  ----------*/
		public function ajaxMostrarProveedor($proveedor, $idMunicipalidad){
			$respuesta = ControladorProveedor::ctrMostrarProveedor($proveedor, $idMunicipalidad);
			echo json_encode($respuesta);
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarRuc') {
		$rucProveedor = $_POST['ruc'];
		try{
		    //$consultaRuc = @file_get_contents("https://dniruc.apisperu.com/api/v1/ruc/".$rucProveedor."?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNyaXN0aWFuMDA3MzE3QGdtYWlsLmNvbSJ9.CmuHB-VHrneCxpiWEc7zA2WFys_CuB-IiQ_FRK7OE-g");
		    $consultaRuc = @file_get_contents("https://dni.optimizeperu.com/api/company/".$rucProveedor."?format=json");
		    if ($consultaRuc === false) {
		    	 throw new Exception('error');
		    }else if($consultaRuc == '{}'){
		    	echo json_encode('{"valor":"vacio"}');
		    }else{
			    echo json_encode($consultaRuc);
		    }
		}catch(Exception $e){
			echo json_encode($e->getMessage());
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarEstado') {
		$idProveedor = $_POST['idProveedor'];
		$estado = $_POST['estadoProveedor'];
		$proveedor = new AjaxProveedor();
		$proveedor->ajaxEstadoProveedor($estado, $idProveedor);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarProveedor') {
		$idProveedor = $_POST['idProveedor'];
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$proveedor = new AjaxProveedor();
		$proveedor->ajaxMostrarProveedor($idProveedor, $idMunicipalidad);
	}
 ?> 