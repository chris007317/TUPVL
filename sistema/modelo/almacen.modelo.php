<?php 
	require_once 'consultas.php';
	Class ModeloAlmacen{
		private $idProducto;
		private $stock;

		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*----------  Nuevo almacen  ----------*/
		public function mdlNuevoAlmacen($idProducto, $cantidad){
			$this->idProducto = $idProducto;
			$this->stock = $cantidad;
			$sql = "SELECT * FROM almacen WHERE idProductoAlmacen = $this->idProducto LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO almacen(stock, idProductoAlmacen) VALUES (?,?)";
				$arrData = array($this->stock, $this->idProducto); 
				$respuesta = $this->consulta->insert($sql, $arrData);
			}else{
				$this->stock = $respuesta['stock'] + $cantidad;
				$sql = "UPDATE almacen SET stock = ? WHERE idProductoAlmacen = $this->idProducto";
				$arrData = array($this->stock); 
				$respuesta = $this->consulta->update($sql, $arrData);
			}
			return $respuesta;
		}
		/*----------  Tabla almaen  ----------*/
		public function mdlMostrarALmacen($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT idAlmacen, codigoProducto, nombreProducto, marcaProducto, stock, (stock*precioUnidad) AS precioTotal, (stock*pesoUnidad) AS pesoTotal, descripcionProducto FROM almacen
				INNER JOIN productos ON idProductoAlmacen = idProducto
			    WHERE idMunicipalidadProducto = $this->idMunicipalidad ORDER BY idAlmacen DESC";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}			

		public function mdlVerProductos($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT nombreProducto, SUM(stock) AS disponible  FROM almacen 
				INNER JOIN productos ON idProductoAlmacen = idProducto
			    WHERE idMunicipalidadProducto = $this->idMunicipalidad 
			    GROUP BY nombreProducto;";
		    $respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}

		public function mdlContarProductos($nombreProducto, $idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT nombreProducto, SUM(stock) AS disponible FROM almacen 
				INNER JOIN productos ON idProductoAlmacen = idProducto
			    WHERE idMunicipalidadProducto = $this->idMunicipalidad AND nombreProducto LIKE '$nombreProducto'
			    GROUP BY nombreProducto;";
		    $respuesta = $this->consulta->select($sql);
		    return $respuesta;
		}

		/*----------  Tabla almaen  por item ----------*/
		public function mdlMostrarProductoALmacen($idMunicipalidad, $item, $valor){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT * FROM almacen 
				INNER JOIN productos ON idProductoAlmacen = idProducto
			    WHERE idMunicipalidadProducto = $this->idMunicipalidad AND $item = '$valor' ORDER BY fechaProducto";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}

		public function mdlMostrarListaProductos($idMunicipalidad, $year, $nombreProducto){
			$this->idMunicipalidad = $idMunicipalidad;
			if ($nombreProducto == '' && $year == '') {
				$sql = "SELECT idProgramarEntrega, idProductoEntrega, mesEntrega, cantidadEntrega, nombreProducto, 
					codigoProducto, descripcionProducto, marcaProducto, entregados, estadoProgramar 
				    FROM programar_entregas 
					INNER JOIN productos ON idProductoEntrega = idProducto
				    WHERE idMunicipalidadProducto = $this->idMunicipalidad AND yearEntrega = YEAR(NOW()) ORDER BY mesEntrega AND nombreProducto";
			}else{
				$sql = "SELECT idProgramarEntrega, idProductoEntrega, mesEntrega, cantidadEntrega, nombreProducto, 
					codigoProducto, descripcionProducto, marcaProducto, entregados, estadoProgramar
				    FROM programar_entregas 
					INNER JOIN productos ON idProductoEntrega = idProducto
				    WHERE idMunicipalidadProducto = $this->idMunicipalidad AND yearEntrega = $year AND nombreProducto LIKE '$nombreProducto' ORDER BY idProgramarEntrega";
			}
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}

		/*----------  registrar entrega  ----------*/
		public function mdlRegistrarEntrega($fechaEntrega, $cantidad, $observacion, $idProducto, $idComite, $idUsuario, $fechaSalida){
			$sql = "INSERT INTO salida_productos(fechaEntrega, cantidad, observacion, idProducto, idComiteSalida, idUsuario, fechaSalida) VALUES (?,?,?,?,?,?,?)";
			$arrData = array($fechaEntrega, $cantidad, $observacion, $idProducto, $idComite, $idUsuario, $fechaSalida); 
			$respuesta = $this->consulta->insert($sql, $arrData);
			return $respuesta;
		}
		/*----------  editar lista entregas  ----------*/
		public function mdlEditarListaProductos($idProducto, $mesEntrega, $yearEntrega, $cantidadProducto){
			$sql = "SELECT * FROM programar_entregas WHERE idProductoEntrega = $idProducto AND mesEntrega = $mesEntrega AND yearEntrega = $yearEntrega LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			$estado = 0;
			$entregas = 0;
			$idProgramarEntrega = $respuesta['idProgramarEntrega'];
			if (!empty($respuesta)) {
				$entregas = $respuesta['entregados'] + $cantidadProducto; 
				if ($respuesta['cantidadEntrega'] == $entregas) {
					$estado = 1;
				}
				$sql = "UPDATE programar_entregas SET entregados = ?, estadoProgramar = ? WHERE idProgramarEntrega = $idProgramarEntrega";
				$arrData = array($entregas, $estado); 
				$respuesta = $this->consulta->update($sql, $arrData);
				return $respuesta;
			}
		}
		/*----------  editar stock de almacen  ----------*/
		public function mdlEditarStockAlmacen($idProducto, $cantidadProducto){
			$sql = "SELECT * FROM almacen WHERE idProductoAlmacen = $idProducto LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			$idAlmacen = $respuesta['idAlmacen'];
			$stock = 0;
			if (!empty($respuesta)) {
				$stock = $respuesta['stock'] - $cantidadProducto; 
				$sql = "UPDATE almacen SET stock = ? WHERE idAlmacen = $idAlmacen ";
				$arrData = array($stock); 
				$respuesta = $this->consulta->update($sql, $arrData);
				return $respuesta;
			}
		}
		/*----------  contar salida comite  ----------*/
		public function mdlContarSalidaComite($idComite, $idMes, $year){
			$sql = "SELECT SUM(cantidad) AS total, nombreProducto FROM salida_productos 
				INNER JOIN productos ON salida_productos.idProducto = productos.idProducto
				WHERE idComiteSalida = $idComite AND MONTH(fechaSalida) = $idMes AND YEAR(fechaSalida) = $year GROUP BY nombreProducto";
		    $respuesta = $this->consulta->selectAll($sql);
		    return $respuesta;
		}

		public function mdlMostrarSalidas($year, $idMes, $idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			if ($idMes == '' && $year == '') {
				$sql = "SELECT idSalidaProducto, nombreComite, nombreProducto, marcaProducto, cantidad, fechaEntrega, observacion, nombrePersona, apellidoPaternoPersona, apellidoMaternoPersona FROM salida_productos 
					INNER JOIN productos ON salida_productos.idProducto = productos.idProducto
				    INNER JOIN comites ON idComiteSalida = idComite
				    INNER JOIN usuarios ON salida_productos.idUsuario = usuarios.idUsuario
				    INNER JOIN personas ON idPersonaUsuario = idPersona
				    WHERE YEAR(fechaSalida) = YEAR(NOW()) AND idMunicipalidadProducto = $this->idMunicipalidad ORDER BY fechaEntrega;";
			}else{
				$sql = "SELECT idSalidaProducto, nombreComite, nombreProducto, marcaProducto, cantidad, fechaEntrega, observacion, nombrePersona, apellidoPaternoPersona, apellidoMaternoPersona FROM salida_productos 
					INNER JOIN productos ON salida_productos.idProducto = productos.idProducto
				    INNER JOIN comites ON idComiteSalida = idComite
				    INNER JOIN usuarios ON salida_productos.idUsuario = usuarios.idUsuario
				    INNER JOIN personas ON idPersonaUsuario = idPersona
				    WHERE YEAR(fechaSalida) = $year AND MONTH(fechaSalida) = $idMes AND idMunicipalidadProducto = $this->idMunicipalidad ORDER BY fechaEntrega;";
			}
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		/*----------  mostrar una salida  ----------*/
		public function mdlMostrarSalida($idSalida){
			$sql = "SELECT idSalidaProducto, nombreComite, nombreProducto, marcaProducto, cantidad, fechaEntrega, observacion FROM salida_productos 
				INNER JOIN productos ON salida_productos.idProducto = productos.idProducto
			    INNER JOIN comites ON idComiteSalida = idComite
			    WHERE idSalidaProducto = $idSalida LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		/*----------  editar salida  ----------*/
		public function mdlEditarSalida($idSalida, $observacion){
			$sql = "UPDATE salida_productos SET observacion = ? WHERE idSalidaProducto = $idSalida";
			$arrData = array($observacion); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		/*----------  consulta par el reporte  ----------*/
		public function mdlReporteSalidas($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT nombreLocalidad, nombreComite, codigoProducto, marcaProducto, nombreProducto, fechaEntrega, cantidad, observacion, year(fechaSalida) AS y, 
				month(fechaSalida) mes, nombrePersona, apellidoPaternoPersona, apellidoMaternoPersona  
				FROM salida_productos
			    INNER JOIN productos ON salida_productos.idProducto = productos.idProducto
			    INNER JOIN comites ON idComiteSalida = idComite
			    INNER JOIN localidades ON idLocalidadComite = idLocalidad
			    INNER JOIN usuarios ON salida_productos.idUsuario = usuarios.idUsuario
			    INNER JOIN personas ON idPersonaUsuario = idPersona
			    WHERE localidades.idMunicipalidad = $this->idMunicipalidad ORDER BY fechaSalida DESC";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}	
		/*----------  contar por producnto  ----------*/
		public function mdlContarSalidas($idMunicipalidad, $valor){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT fechaSalida,  sum(cantidad) AS cantidad FROM salida_productos
			INNER JOIN productos ON salida_productos.idProducto = productos.idProducto
			WHERE fechaSalida >= date_sub(curdate(), interval 12 month) AND idMunicipalidadProducto = $this->idMunicipalidad AND nombreProducto = '$valor'
			GROUP BY fechaSalida 
            ORDER BY fechaSalida DESC";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}

				/*----------  generar pecosas  ----------*/
		public function mdlGenerarPecosa($idMunicipalidad, $idComite, $mes, $year){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT idSalidaProducto, DAY(fechaEntrega) AS dia, MONTH(fechaEntrega) AS mes, YEAR(fechaEntrega) AS y, nombreProducto, cantidad,
				marcaProducto, codigoProducto, precioUnidad, (precioUnidad * cantidad) AS total 
				FROM salida_productos
				INNER JOIN productos ON salida_productos.idProducto = productos.idProducto
			    WHERE idMunicipalidadProducto = $this->idMunicipalidad AND idComiteSalida = $idComite AND MONTH(fechaSalida) = $mes AND YEAR(fechaSalida) = $year 
			    ORDER BY idSalidaProducto DESC;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
	}