<?php 
	require_once '../controlador/socio.controlador.php';
	require_once '../modelo/socio.modelo.php';
	session_start();
	Class TablaSocios{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$idMunicipalidad =  intval($_SESSION['idMunicipalidadPvl']);
			$socios = '';
			if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarActivos') {
				$socios = ControladorSocio::ctrListarSocios($idMunicipalidad, $_POST['estado']);	
			}else{
				$socios = ControladorSocio::ctrListarSocios($idMunicipalidad, '');	
			}
			if (count($socios) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($socios as $key => $value) {
					if ($value['idDireccion'] == null) {
						$direccion = "<h5><span class='badge badge-danger'>Dirección no consignada</span></h5";
						$acciones = "<div class='btn-group'>";
					}else{
						$direccion = $value['nombreDireccion'].' N° '.$value['numero'];
						$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm editarDireccion' idDireccion='".$value['idDireccion']."' idPersona='".$value['idPersonaSocio']."' data-toggle='modal' data-target='#modalDireccion' title='Editar dirección'><i class='fas fa-map-marked-alt'></i></button>";
					}
					$verBenef = '';
					if ($value['estadoSocio'] == 1) {
						$estado = "<div class='text-center'><button class='btn btn-warning btn-sm text-white btnActivarSocio' estadoSocio='0' idSocio='".$value['idSocio']."'>Activo</button></div>";
						$verBenef = "<button class='btn btn-danger btn-sm verBeneficiarios' title='Ver beneficiarios' idSocio='".$value['idSocio']."' data-toggle='modal' data-target='#modalBeneficiarios'><i class='fas fa-users'></i></button>";
					}else{
						$estado = "<div class='text-center'><button class='btn btn-dark btn-sm text-white btnActivarSocio' estadoSocio='1' idSocio='".$value['idSocio']."'>Inactivo</button></div>";
					}
					$acciones .= "<button class='btn btn-success btn-sm editarSocio' title='Editar Socio' idSocio='".$value['idSocio']."' data-toggle='modal' data-target='#modalSocio'><i class='fas fa-user-edit'></i></button>".$verBenef."</div>";  
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].', '.$value['nombrePersona'].'",
							"'.$value['dniPersona'].'",
							"'.$direccion.'",
							"'.$value['descripcion'].'",
							"'.$value['correoSocio'].'",
							"'.$value['celular'].'",
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

	$planes = new TablaSocios();
	$planes->mostrarTabla();