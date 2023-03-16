<?php 
	require_once 'consultas.php';
	Class ModeloUsuario{
		private $idUsuario;
		private $nombreUsuario;
		private $contraUsuario;
		private $correoUsuario;
		private $rutaImg;
		private $celularUsuario;
		private $idPersona;
		private $idTipoUsuario;
		private $idMunicipalidad; 
		private $cosulta;
		
		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*----------  Mostrar Departamentos  ----------*/
		public function mdlMostrarUsuario($atributo, $valor){
			$sql = "SELECT * FROM usuarios WHERE $atributo = '$valor' LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		/*----------  mostrar todos los datos del usuario  ----------*/
		public function mdlMostrarDatosUsuario($idUsuario){
			$sql = "SELECT fotoUsuario, nombrePersona, apellidoPaternoPersona, apellidoMaternoPersona, nombreMunicipalidad, horaEntrada, horaSalida, idTipoUsuario
				FROM usuarios 
				INNER JOIN personas ON usuarios.idPersonaUsuario = personas.idPersona
			    INNER JOIN municipalidades ON idMunicipalidadUsuario = idMunicipalidad WHERE idUsuario = $idUsuario LIMIT 1";
			   $respuesta = $this->consulta->select($sql);
			   return $respuesta;
		}
		/*----------  mostrar tipo usuario  ----------*/
		public function mdlMostrarTipoUsuario(){
			$sql = "SELECT * FROM tipo_usuario WHERE idTipoUsuario != 1";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;
		}
		/*----------  mostrar usuario  ----------*/
		public function mdlVerUsuario($item, $valor){
			$sql = "SELECT usuarios.*, dniPersona, apellidoPaternoPersona, apellidoMaternoPersona, nombrePersona FROM usuarios 
				INNER JOIN personas ON idPersonaUsuario = idPersona 
				WHERE $item = '$valor' LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		/*----------  agregar nuevo usuario  ----------*/
		public function mdlAgregarUsuario($nombreUsuario, $contraUsuario, $correoUsuario, $ruta, $celularUsuario, $idPersona, $idTipoUsuario, $idMunicipalidad){
			$this->nombreUsuario = $nombreUsuario;
			$this->contraUsuario = $contraUsuario;
			$this->correoUsuario = $correoUsuario;
			$this->rutaImg = $ruta;
			$this->celularUsuario = $celularUsuario;
			$this->idPersona = $idPersona;
			$this->idTipoUsuario = $idTipoUsuario;
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT * FROM usuarios WHERE nombreUsuario = '$this->nombreUsuario' LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO usuarios (nombreUsuario, contraUsuario, correoUsuario, fotoUsuario, celularUsuario, idPersonaUsuario, idTipoUsuario, idMunicipalidadUsuario) VALUES (?,?,?,?,?,?,?,?)";
				$arrData = array($this->nombreUsuario, $this->contraUsuario, $this->correoUsuario, $this->rutaImg, $this->celularUsuario, $this->idPersona, $this->idTipoUsuario, $this->idMunicipalidad); 
				$respuesta = $this->consulta->insert($sql, $arrData);	
			}else{
				$respuesta = 'existe';
			}
			return $respuesta;
		}
		/*----------  mostrar usuarios  ----------*/
		public function mdlMostrarUsuarios($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT idUsuario, nombreUsuario, correoUsuario, fotoUsuario, celularUsuario, estadoUsuario, idPersona, nombrePersona, apellidoPaternoPersona,
				apellidoMaternoPersona, usuarios.idTipoUsuario, nombreTipoUsuario
			    FROM usuarios
				INNER JOIN personas ON idPersonaUsuario = idPersona
				INNER JOIN tipo_usuario ON usuarios.idTipoUsuario = tipo_usuario.idTipoUsuario
				WHERE idMunicipalidadUsuario = $this->idMunicipalidad";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;
		}
		/*----------  editar campos de un usuario  ----------*/
		public function mdlEditarUsuario($nombreUsuario, $correoUsuario, $celularUsuario, $idTipoUsuario, $idUsuario){
			$this->nombreUsuario = $nombreUsuario;
			$this->correoUsuario = $correoUsuario;
			$this->celularUsuario = $celularUsuario;
			$this->idTipoUsuario = $idTipoUsuario;
			$this->idUsuario = $idUsuario;
			$sql = "UPDATE usuarios  SET  nombreUsuario = ?, correoUsuario = ?, celularUsuario = ?, idTipoUsuario = ? 
					WHERE idUsuario = $this->idUsuario";
			$arrData = array($this->nombreUsuario, $this->correoUsuario, $this->celularUsuario, $this->idTipoUsuario); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}

		public function mdlEditarImg($idUsuario, $ruta){
			$this->idUsuario = $idUsuario;
			$this->rutaImg = $ruta;
			$sql = "UPDATE usuarios  SET  fotoUsuario = ? 
					WHERE idUsuario = $this->idUsuario";
			$arrData = array($this->rutaImg); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}

		public function mdlEditarContra($idUsuario, $contraUsuario){
			$this->idUsuario = $idUsuario;
			$this->contraUsuario = $contraUsuario;
			$sql = "UPDATE usuarios  SET  contraUsuario = ? 
					WHERE idUsuario = $this->idUsuario";
			$arrData = array($this->contraUsuario); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}

		public function mdlEditarEstado($idUsuario, $estado){
			$this->idUsuario = $idUsuario;
			$sql = "UPDATE usuarios  SET  estadoUsuario = ? 
					WHERE idUsuario = $this->idUsuario";
			$arrData = array($estado); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}

		public function mdlVerUsuarioId($item, $valor, $idUsuario){
			$sql = "SELECT usuarios.*, dniPersona, apellidoPaternoPersona, apellidoMaternoPersona, nombrePersona FROM usuarios 
				INNER JOIN personas ON idPersonaUsuario = idPersona 
				WHERE $item = '$valor' AND idUsuario != $idUsuario LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
	}