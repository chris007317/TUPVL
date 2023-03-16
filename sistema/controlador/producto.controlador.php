<?php 
	Class ControladorProducto{
		/*----------  Agregar Producto  ----------*/
		static public function ctrAgregarProducto(){
			if (isset($_POST['txtCodigoProducto']) && isset($_SESSION['idMunicipalidadPvl'])) {
				$codigoProducto = trim($_POST["txtCodigoProducto"]);
				$idMunicipalidad = intval($_SESSION['idMunicipalidadPvl']);
				if (preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtNombreProducto"]) &&  
					preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtMarcaProducto"]) &&
					preg_match('/^[0-9a-zA-Z]+$/', $codigoProducto) &&
					(preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtDescripcionProducto"]) || empty($_POST['txtDescripcionProducto'])) &&
					is_numeric($_POST['btxtPesoProducto']) && is_numeric($_POST['txtPrecioProducto'])
				) {
					$peso = doubleval($_POST['btxtPesoProducto']);
					$precio = doubleval($_POST['txtPrecioProducto']);
					$nombreProducto = $_POST['txtNombreProducto'];
					$descripcionProducto = $_POST['txtDescripcionProducto'];
					$marcaProducto = $_POST['txtMarcaProducto'];
					$ruta = '';
					$directorio = "vistas/img/productos";
					if (isset($_FILES['flImgProducto']['tmp_name']) && !empty($_FILES['flImgProducto']['tmp_name'])) {
						list($ancho, $alto) = getimagesize($_FILES['flImgProducto']['tmp_name']);
	   					$nuevoAncho = 480;
						$nuevoAlto = 382; 
						$nombreImg = uniqid().'-'.$codigoProducto.'-'.$idMunicipalidad;
						if ($_FILES['flImgProducto']['type'] == "image/jpeg") {
							$ruta = $directorio."/".$nombreImg.".jpg";
							$origen = imagecreatefromjpeg($_FILES['flImgProducto']['tmp_name']); 
							$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
							imagejpeg($destino, $ruta);
						}else if($_FILES['flImgProducto']['type'] == "image/png"){
							$ruta = $directorio."/".$nombreImg.".png";
							$origen = imagecreatefrompng($_FILES['flImgProducto']['tmp_name']);
							$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
							imagealphablending($destino, FALSE);
							imagesavealpha($destino, TRUE);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
							imagepng($destino, $ruta);
						}else{
							echo mensaje('¡ERROR!', '¡No se permiten formatos diferentes a JPG y/o PNG!', 'error');
							return;
						}
					}else{
						$ruta = $directorio.'/producto.png';
					}
					$agregar = new ModeloProducto();
					$respuesta = $agregar->mdlAgregarProducto($nombreProducto, $codigoProducto, $descripcionProducto, $precio, $peso, $marcaProducto, $ruta, $idMunicipalidad);
				 	if($respuesta == 'existe'){
		 				echo mensaje('¡ADVERTENCIA!', '¡El codigo del producto ya existe!', 'warning');
			 		}else if ($respuesta > 0) {
				 		echo mensaje('¡CORRECTO!', '¡El producto fue agregado con exito!', 'success');
				 	}else{
				 		echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar el producto!', 'error');
				 	}
				}else{
					echo mensaje('CORREGIR!', '¡No se permiten caracteres especiales en ninguno de los campos!', 'warning');
				}
			}	
		}
		/*----------  Mostrar productos  ----------*/
		static public function ctrMostrarProductos($valor, $idMunicipalidad, $pagina){
			$respuesta = new ModeloProducto();
			return $respuesta->mdlMostrarProductos($valor, $idMunicipalidad, $pagina);
		}
		/*----------  Contar productos  ----------*/
		static public function ctrContarProductos($idMunicipalidad, $valor){
			$respuesta = new ModeloProducto();
			return $respuesta->mdlContarProductos($idMunicipalidad, $valor);
		}
		/*----------  Mostrar un solo producto  ----------*/
		static public function ctrMostrarProducto($idProducto, $idMunicipalidad){
			$valor = $idProducto;
			$atributo = 'idProducto';
			$respuesta = new ModeloProducto();
			return $respuesta->mdlMostrarProducto($atributo, $valor, $idMunicipalidad);
		}
		/*----------  Mostrar lista de productos  ----------*/
		static public function ctrMostrarListaProductos($idMunicipalidad){
			$respuesta = new ModeloProducto();
			return $respuesta->mdlMostrarListaProductos($idMunicipalidad);
		}
		/*----------  Editar Producto  ----------*/
		static public function ctrEditarProducto(){
			if (isset($_POST['txtEditarCodigoProducto']) && isset($_POST['idProducto']) && isset($_SESSION['idMunicipalidadPvl']) && isset($_POST['imgActualProd'])) {
				$codigoProducto = trim($_POST["txtEditarCodigoProducto"]);
				$idMunicipalidad = intval($_SESSION['idMunicipalidadPvl']);
				$idProducto = $_POST['idProducto'];
				if (preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtEditarMarcaProducto"]) &&
					preg_match('/^[0-9a-zA-Z]+$/', $codigoProducto) &&
					(preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtEditarDescripcionProducto"]) || empty($_POST["txtEditarDescripcionProducto"])) &&
					is_numeric($_POST['btxtEditarPesoProducto']) && is_numeric($_POST['txtEditarPrecioProducto'])
				) {
					$peso = doubleval($_POST['btxtEditarPesoProducto']);
					$precio = doubleval($_POST['txtEditarPrecioProducto']);
					$descripcionProducto = $_POST['txtEditarDescripcionProducto']; 
					$marcaProducto = $_POST['txtEditarMarcaProducto'];
					$ruta = $_POST['imgActualProd'];
					$directorio = "vistas/img/productos";
					if (isset($_FILES['flEditarImgProducto']['tmp_name']) && !empty($_FILES['flEditarImgProducto']['tmp_name'])) {
						list($ancho, $alto) = getimagesize($_FILES['flEditarImgProducto']['tmp_name']);
	   					$nuevoAncho = 480;
						$nuevoAlto = 382; 
						$nombreImg = uniqid().'-'.$codigoProducto.'-'.$idMunicipalidad;
						if ($_FILES['flEditarImgProducto']['type'] == "image/jpeg") {
							$ruta = $directorio."/".$nombreImg.".jpg";
							$origen = imagecreatefromjpeg($_FILES['flEditarImgProducto']['tmp_name']); 
							$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
							imagejpeg($destino, $ruta);
						}else if($_FILES['flEditarImgProducto']['type'] == "image/png"){
							$ruta = $directorio."/".$nombreImg.".png";
							$origen = imagecreatefrompng($_FILES['flEditarImgProducto']['tmp_name']);
							$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
							imagealphablending($destino, FALSE);
							imagesavealpha($destino, TRUE);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
							imagepng($destino, $ruta);
						}else{
							echo mensaje('¡ERROR!', '¡No se permiten formatos diferentes a JPG y/o PNG!', 'error');
							return;
						}
					}
					$agregar = new ModeloProducto();
					$respuesta = $agregar->mdlEditarProducto($idProducto, $codigoProducto, $descripcionProducto, $precio, $peso, $marcaProducto, $ruta, $idMunicipalidad);	
				 	if  ($respuesta == 'existe'){
		 				echo mensaje('¡ADVERTENCIA!', '¡El codigo del producto ya existe!', 'warning');
			 		}else if ($respuesta == 'ok'){
						if ($_POST['imgActualProd'] != 'vistas/img/productos/producto.png') {
							unlink($_POST['imgActualProd']);
						}
				 		echo mensaje('¡CORRECTO!', '¡El producto fue editado con exito!', 'success');
				 		return;
				 	}else{
				 		echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar el producto!', 'error');
				 	}
				}else{
					echo mensaje('CORREGIR!', '¡No se permiten caracteres especiales en ninguno de los campos!', 'warning');
				}
			}	
		}
		/*----------  editar un solo campo de un producto  ----------*/
		public function ctrEditarCampoProducto($item, $valor, $idProducto){
			$respuesta = new ModeloProducto();
			$editar = $respuesta->mdlEditarCampoProducto($item, $valor, $idProducto);	
			if($editar){
				return 'ok';
			}
		}
		static public function ctrReporteProducto($idMunicipalidad){
			$respuesta = new ModeloProducto();
			return $respuesta->mdlReporteProducto($idMunicipalidad);
		}
	}