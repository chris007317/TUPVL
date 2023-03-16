<?php 
	Class ControladorRequisitoMunicipalidad{
		/*----------  Agregar requisitos por tipo de beneficiarios  ----------*/
		static public function ctrRegistrarRequisitoMunicipalidad(){
			if (isset($_POST['cmbAgregarTipoBenef']) && isset($_POST['cmbAgregarRequisitoBenef'])) {
				$idTipoBeneficiario =  $_POST['cmbAgregarTipoBenef'];
				$idRequisito =  $_POST['cmbAgregarRequisitoBenef'];
				$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
				$agregar = new ModeloRequisitoMunicipalidad();
			 	$respuesta = $agregar->mdlRegistrarRequisitoMunicipalidad($idMunicipalidad, $idRequisito, $idTipoBeneficiario);
			 	if($respuesta == 'existe'){
		 			echo mensaje('¡ADVERTENCIA!', '¡El requisito ya existe!', 'warning');
			 	}else if($respuesta > 0) {
					echo mensaje('¡CORRECTO!', '¡El requisito ha sido registrado con exito!', 'success');
			 	}else{
			 		echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar el requisito!', 'error');
			 	}
			}
		}
		/*----------  Mostrar requisitos por tipo beneficiarios  ----------*/
		static public function ctrMostrarRequisitoMunicipalidad($idMunicipalidad, $idTipoBeneficiario){
			$respuesta = new ModeloRequisitoMunicipalidad();
			return $respuesta->mdlMostrarRequisitoMunicipalidad($idMunicipalidad, $idTipoBeneficiario);
		}
		/*----------  editar estado requisito  ----------*/
		static public function ctrEditarRequisitoMunicipalidad($item, $valor, $idReMuni){
			$respuesta = new ModeloRequisitoMunicipalidad();
			$editar = $respuesta->mdlEditarRequisitoMunicipalidad($item, $valor, $idReMuni);	
			if($editar){
				return 'ok';
			}
		}
		/*----------  editar estado requisito  ----------*/
		static public function ctrEliminarRequisitoMunicipalidad($idReMuni){
			$respuesta = new ModeloRequisitoMunicipalidad();
			$eliminar = $respuesta->mdlEliminarRequisitoMunicipalidad($idReMuni);	
			if($eliminar){
				return 'ok';
			}
		}
 	}

 