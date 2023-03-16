<?php 
	Class ControladorMunicipalidad{
		/*----------  Mostrar dats de una municipalidad  ----------*/
		static public function ctrMostrarMunicipalidad($idMunicipalidad){
			$valor = $idMunicipalidad;
			$atributo = 'idMunicipalidad';
			$respuesta = new ModeloMunicipalidad();
			return $respuesta->mdlMostrarMunicipalidad($atributo, $valor);
		}
		/*----------  Editar horario de la municipalidad  ----------*/
		public function ctrEditarHorario(){
			if (isset($_POST['horaEntrada']) && isset($_POST['horaSalida'])) {
				$horaEntrada = $_POST['horaEntrada'];
				$horaSalida = $_POST['horaSalida'];
				$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
				if (strtotime($horaEntrada) > strtotime($horaSalida)) {
					echo '<div class="alert alert-danger ">Error: La hora de entrada no puede ser mayor a la hora de salida</div>';
				}else if($horaEntrada == $horaSalida){
					echo '<div class="alert alert-danger ">Error: La hora de entrada no puede ser igual a la hora de salida</div>';
				}else{
					$respuesta = new ModeloMunicipalidad();
					$edit = $respuesta->mdlEditarHorario($horaEntrada, $horaSalida, $idMunicipalidad);	
					if ($edit) {
						echo '<script>
								swal({
									title: "¡CORRECTO!",
									text: "¡El horario fue editado con exito!",
									type: "success",
									showConfirmButton: true,
									confirmButtonText: "¡Aceptar!"
								}).then(function(result){
									if(result.value){
										history.back();
									}
								});
						</script>';
					}
				}
			}
		}
		/*----------  Editar imagen municipalidad  ----------*/
		public function ctrEditarImgMuni(){
			if (isset($_POST['idMunicipalidad']) && !empty($_POST['idMunicipalidad'])) {
				if (isset($_FILES['imgEditarMuni']['tmp_name']) && !empty($_FILES['imgEditarMuni']['tmp_name'])) {
					list($ancho, $alto) = getimagesize($_FILES['imgEditarMuni']['tmp_name']);
   					$nuevoAncho = 480;
					$nuevoAlto = 382;
					$idMunicipalidad = $_POST['idMunicipalidad'];
					$directorio = "vistas/img/municipalidades";
					if ($_FILES['imgEditarMuni']['type'] == "image/jpeg") {
						$nombreImg = uniqid().'-'.$idMunicipalidad;
						$ruta = $directorio."/".$nombreImg.".jpg";
						$origen = imagecreatefromjpeg($_FILES['imgEditarMuni']['tmp_name']);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagejpeg($destino, $ruta);
						$ruta = 'img/municipalidades/'.$nombreImg.'.jpg';

					}else if($_FILES['imgEditarMuni']['type'] == "image/png"){
						$nombreImg = uniqid().'-'.$idMunicipalidad;
						$ruta = $directorio."/".$nombreImg.".png";
						$origen = imagecreatefrompng($_FILES['imgEditarMuni']['tmp_name']);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagealphablending($destino, FALSE);
						imagesavealpha($destino, TRUE);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagepng($destino, $ruta);
						$ruta = 'img/municipalidades/'.$nombreImg.'.png';
					}else{
						echo mensaje('¡ERROR!', '¡No se permiten formatos diferentes a JPG y/o PNG!', 'error');
						return;
					}
					$respuesta = new ModeloMunicipalidad();
					$editado = $respuesta->mdlEditarImgMuni($ruta, $idMunicipalidad);
					if ($editado == 'ok') {
						if (isset($_POST['imgActualMuni'])) {
							if ($_POST['imgActualMuni'] != 'vistas/img/municipalidades/municipalidad.png') {
								unlink($_POST['imgActualMuni']);
							}
						}
						echo mensaje('¡CORRECTO!', '¡La imagen ha sido actualizada correctamente!', 'success');
					}else{
						echo mensaje('¡ERROR!', '¡La imagen ha no pudo actualizarse correctamente!', 'error');
					}
				}
			}
		}

		/*----------  Mostrar datos de una municpalidad y responsable  ----------*/
		static public function ctrMostrarrResponsbleMunicipalidad($idMunicipalidad){
			$respuesta = new ModeloMunicipalidad();
			return $respuesta->mdlMostrarResponsableMunicipalidad($idMunicipalidad);
		}
		/*----------  agregar periodo por año  ----------*/
		public function ctrRegistrarPeriodoMunicipalidad(){
			if (isset($_POST['yearPerido']) && isset($_POST['cmbPeriodo']) && !empty($_POST['yearPerido']) && !empty($_POST['cmbPeriodo'])) {
				$yearPerido = $_POST['yearPerido'];
				$periodo = $_POST['cmbPeriodo'];
				$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
				$respuesta = new ModeloMunicipalidad();
				$agregar = $respuesta->mdlRegistrarPeriodoMunicipalidad($idMunicipalidad, $yearPerido, $periodo);	
				if ($agregar > 0) {
					echo mensaje('¡CORRECTO!', '¡Se registro el periodo de entrega para los productos!', 'success');
				}else{
					echo mensaje('ERROR!', '¡Ocurrió un error al relaizar la acción!', 'error');
				}
				
			}
		}

		static public function ctrTablaPeriodo($idMunicipalidad){
			$respuesta = new ModeloMunicipalidad();
			return $respuesta->mdlTablaPeriodo($idMunicipalidad);
		}

		static public function ctrMostrarPeriodoMunicipalidad($idMunicipalidad){
			$respuesta = new ModeloMunicipalidad();
			return $respuesta->mdlMostrarPeriodoMunicipalidad($idMunicipalidad);
		}
		/*----------  mostrar los periodos  ----------*/
		static public function ctrMostrarPeriodos($idMunicipalidad, $nombreProducto){
			$respuesta = new ModeloMunicipalidad();
			return $respuesta->mdlMostrarPeriodos($idMunicipalidad, $nombreProducto); 
		}	

		static public function ctrGuardarPrograma($idProducto, $mesEntrega, $cantidad, $year){
			$respuesta = new ModeloMunicipalidad();
			return $respuesta->mdlGuardarPrograma($idProducto, $mesEntrega, $cantidad, $year); 
		}
		/*----------  mostrar los periodos  ----------*/
		static public function ctrMostrarPeriodosYear($idMunicipalidad){
			$respuesta = new ModeloMunicipalidad();
			return $respuesta->mdlMostrarPeriodosYear($idMunicipalidad); 
		}			

		public function ctrMostrarPeriodosMes($idMunicipalidad, $mes, $year, $nombreProducto){
			$respuesta = new ModeloMunicipalidad();
			return $respuesta->mdlMostrarPeriodosMes($idMunicipalidad, $mes, $year, $nombreProducto); 
		}
		public function ctrMostrarProductosDisponibles($idMunicipalidad, $mes, $year, $nombreProducto){
			$respuesta = new ModeloMunicipalidad();
			return $respuesta->mdlMostrarProductosDisponibles($idMunicipalidad, $mes, $year, $nombreProducto); 
		}
		static public function ctrGuardarEntrega($idComite, $contarBenefComite, $mes, $year, $idNomProd, $benefId){
			$respuesta = new ModeloMunicipalidad();
			return $respuesta->mdlGuardarEntrega($idComite, $contarBenefComite, $mes, $year, $idNomProd, $benefId); 
		}
		static public function ctrContarPorMes($idMunicipalidad, $idMes, $year, $idNomProd){
			$respuesta = new ModeloMunicipalidad();
			return $respuesta->mdlContarPorMes($idMunicipalidad, $idMes, $year, $idNomProd); 
		}
		static public function ctrMostrarComites($idMunicipalidad, $idMes, $year, $idNomProd){
			$respuesta = new ModeloMunicipalidad();
			return $respuesta->mdlMostrarComites($idMunicipalidad, $idMes, $year, $idNomProd); 	
		} 
		/*----------  ver disponibilidad  ----------*/
		static public function ctrVerDisponibilidad($idMunicipalidad, $year, $mes, $estado){
			$respuesta = new ModeloMunicipalidad();
			return $respuesta->mdlVerDisponibilidad($idMunicipalidad, $year, $mes, $estado); 	
		}
		/*----------  datos para la pecosa  ----------*/
		static public function ctrMostrarPadron($idMunicipalidad, $idComite, $idMes, $year){
			$respuesta = new ModeloMunicipalidad();
			return $respuesta->mdlMostrarPadron($idMunicipalidad, $idComite, $idMes, $year);
		}
		
 	}