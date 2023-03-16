<?php 
	require_once '../controlador/producto.controlador.php';
		require_once '../controlador/ruta.controlador.php';
	require_once '../modelo/producto.modelo.php';
	session_start();
	Class AjaxProductos{
		/*----------  buscar requisito por municipalidad  ----------*/
		public function ajaxBuscarProductos($valor, $idMunicipalidad, $pagina){
			if ($pagina == 0) {
				$comienzo = $pagina;
			}else{
				$comienzo = ($pagina - 1) * 6;
			}
			$respuesta = ControladorProducto::ctrMostrarProductos($valor, $idMunicipalidad, $comienzo);
			$ruta = ControladorRuta::ctrServidor();
			$template = ''; 
			foreach ($respuesta as $key => $value) {
				if ($value['estado'] == 1) {
					$estado = '<button class="btn btn-warning btn-sm text-white mt-1 btnActivarProducto" estadoProducto="0" title="Desactivar" idProducto="'.$value['idProducto'].'">
                            	<i class="fas fa-caret-down"></i> Activo
	                          </button>';
				}else{
					$estado = '<button class="btn btn-secondary btn-sm text-white mt-1 btnActivarProducto" estadoProducto="1" title="Activar" idProducto="'.$value['idProducto'].'">
                        		<i class="fas fa-caret-up"></i> Activo
	                          </button>';
				}
				$template .='<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
			                    <div class="card bg-light">
			                      <div class="card-header text-muted border-bottom-0">
			                        <h1 class="badge badge-info">'.$value['codigoProducto'].'</h1>
			                      </div>
			                      <div class="card-body pt-0">
			                        <div class="row">
			                          <div class="col-7">
			                            <h2 class="lead"><b>'.$value['nombreProducto'].'</b></h2>
			                            <p class="text-muted text-sm"><b>Marca: </b> '.$value['marcaProducto'].'</p>
			                            <p class="text-muted text-sm"><b>Descripción: </b> '.$value['descripcionProducto'].'</p>
			                            <ul class="ml-4 mb-0 fa-ul text-muted">
			                              <li class="small"><span class="fa-li"><i class="fas fa-weight"></i></span> Peso: '.$value['pesoUnidad'].' Gramos</li>
			                              <li class="small"><span class="fa-li"><i class="fas fa-dollar-sign"></i></span> Precio: '.$value['precioUnidad'].' Soles</li>
			                            </ul>
			                          </div>
			                          <div class="col-5 text-center">
			                            <img src="'.$ruta.$value['imgProducto'].'" alt="" class="img-circle img-fluid">
			                          </div>
			                        </div>
			                      </div>
			                      <div class="card-footer">
			                        <div class="text-right">
			                          <button class="btn btn-sm btn-success mt-1 editarProducto" title="Editar" idProducto="'.$value['idProducto'].'" data-toggle="modal" data-target="#editarAlimento">
			                            <i class="fas fa-pencil-alt"></i>
			                          </button>
			                          '.$estado.'
			                        </div>
			                      </div>
			                    </div>
			                  </div>';
			}
			echo $template;
		}
		/*----------  contar el número de páginas  ----------*/
		public function ajaxContarProducto($idMunicipalidad, $valor, $pagina){
			$respuesta = ControladorProducto::ctrContarProductos($idMunicipalidad, $valor);
			$numeroPaginas = ceil($respuesta['totalProductos'] / 6);			
			$template = ''; 
			if ($numeroPaginas > 1) {
             	for ($i = 1; $i <= $numeroPaginas; $i++) {
                    if ($pagina == $i) {
                		$template .= '<li class="page-item active"><button class="page-link" disabled>'.$pagina.'</button></li>';
                    } else {
                        $template .= '<li class="page-item"><button class="page-link btnPagina" pagina="'.$i.'" valor="'.$valor.'">'.$i.'</button></li>';
                    }    
              	} 
			}else{
				$template .= '<li class="page-item active"><button class="page-link" disabled>1</button></li>';
			}
			echo $template;
		}
		/*----------  Mostrar dato de un solo producto  ----------*/
		public function ajaxMostrarProducto($idProducto, $idMunicipalidad){
			$respuesta = ControladorProducto::ctrMostrarProducto($idProducto, $idMunicipalidad);
			echo json_encode($respuesta);

		}
		/*----------  editar estado producto  ----------*/
		public function ajaxEstadoProducto($estado, $idProducto){
			$item = 'estado';
			$respuesta = ControladorProducto::ctrEditarCampoProducto($item, $estado, $idProducto);
			echo $respuesta;
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarProductos') {
		$valor = $_POST['dato'];
		$pagina = $_POST['pagina'];
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$propuestas = new AjaxProductos();
		$propuestas->ajaxBuscarProductos($valor, $idMunicipalidad, $pagina);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'contarProductos') {
		$valor = $_POST['dato'];
		$pagina = $_POST['pagina'];
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$propuestas = new AjaxProductos();
		$propuestas->ajaxContarProducto($idMunicipalidad, $valor, $pagina);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarProduto') {
		$idProducto = $_POST['idProducto'];
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$propuestas = new AjaxProductos();
		$propuestas->ajaxMostrarProducto($idProducto, $idMunicipalidad);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarEstado') {
		$idProducto = $_POST['idProducto'];
		$estado = $_POST['estadoProducto'];
		$propuestas = new AjaxProductos();
		$propuestas->ajaxEstadoProducto($estado, $idProducto);
	}