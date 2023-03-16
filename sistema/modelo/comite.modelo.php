<?php 
require_once 'consultas.php';
Class ModeloComite{
	private $nombreComite;
	private $direccionComite;
	private $numeroComite;
	private $descripcionComite;
	private $idLocalidad;
	private $idMunicipalidad;
	private $idComite;

	public function __construct(){
		$this->consulta = new Consultas();
	}
	/*----------  Agregar comite  ----------*/
	public function mdlAgregarComite($nombreComite, $direccionComite, $numeroComite, $descripcionComite, $idLocalidad, $idMunicipalidad){
		$this->nombreComite = $nombreComite;
		$this->direccionComite = $direccionComite;
		$this->numeroComite = $numeroComite;
		$this->descripcionComite = $descripcionComite;
		$this->idLocalidad = $idLocalidad;
		$this->idMunicipalidad = $idMunicipalidad;
		$sql = "SELECT comites.* FROM comites 
			INNER JOIN localidades ON idLocalidadComite = idLocalidad 
			WHERE nombreComite = '$this->nombreComite' AND idLocalidad = $this->idLocalidad AND idMunicipalidad = $this->idMunicipalidad";
		$respuesta = $this->consulta->select($sql);
		if(empty($respuesta)){
			$sql = "INSERT INTO comites(nombreComite, direccionComite, numeroCalle, descripcionComite, idLocalidadComite) VALUES (?,?,?,?,?)";
			$arrData = array($this->nombreComite, $this->direccionComite, $this->numeroComite, $this->descripcionComite, $this->idLocalidad); 
			$respuesta = $this->consulta->insert($sql, $arrData);	
		}else{
			$respuesta = 'existe';
		}
		return $respuesta;
	}
	/*----------  Buscar comites  ----------*/
	public function mdlMostrarComites($idMunicipalidad){
		$this->idMunicipalidad = $idMunicipalidad;
		$sql = "SELECT idComite, nombreComite, direccionComite, numeroCalle, descripcionComite, nombreLocalidad, estadoComite FROM comites
			INNER JOIN localidades ON idLocalidadComite = idLocalidad 
			WHERE idMunicipalidad = $this->idMunicipalidad AND estadoLocalidad = TRUE ORDER BY nombreLocalidad ASC";
		$respuesta = $this->consulta->selectAll($sql);
		return $respuesta;
	}
	/*----------  Mostrar comites por localidad  ----------*/
	public function mdlMostrarComitesLocalidad($idMunicipalidad, $idLocalidad){
		$this->idMunicipalidad = $idMunicipalidad;
		$this->idLocalidad = $idLocalidad;
		$sql = "SELECT idComite, nombreComite, direccionComite, numeroCalle, descripcionComite, nombreLocalidad, estadoComite FROM comites
			INNER JOIN localidades ON idLocalidadComite = idLocalidad 
			WHERE idMunicipalidad = $this->idMunicipalidad AND idLocalidadComite = $this->idLocalidad AND estadoLocalidad = TRUE ORDER BY nombreComite ASC";
		$respuesta = $this->consulta->selectAll($sql);
		return $respuesta;
	} 
	/*----------  Editar un campo de un comite  ----------*/
	public function mdlEditarCampoComite($item, $valor, $idComite){
		$this->idComite = $idComite;
		$sql = "UPDATE comites SET $item = ? WHERE idComite = $this->idComite";
		$arrData = array($valor); 
		$respuesta = $this->consulta->update($sql, $arrData);
		return $respuesta;
	}
	/*----------  Mostrar un comite  ----------*/
	public function mdlMostrarComite($idComite){
		$this->idComite = $idComite;
		$sql = "SELECT * FROM comites WHERE idComite = $this->idComite LIMIT 1";
		$respuesta = $this->consulta->select($sql);
		return $respuesta;
	}
	/*----------  editar campos de un comite  ----------*/
	public function mdlEditarComite($nombreComite, $direccionComite, $numeroComite, $descripcionComite, $idLocalidad, $idComite){
		$this->nombreComite = $nombreComite;
		$this->direccionComite = $direccionComite;
		$this->numeroComite = $numeroComite;
		$this->descripcionComite = $descripcionComite;
		$this->idLocalidad = $idLocalidad;
		$this->idComite = $idComite;
		$sql = "UPDATE comites SET  nombreComite = ?, direccionComite = ?, numeroCalle = ?, descripcionComite = ?, idLocalidadComite = ? 
				WHERE idComite = $this->idComite";
		$arrData = array($this->nombreComite, $this->direccionComite, $this->numeroComite, $this->descripcionComite, $this->idLocalidad); 
		$respuesta = $this->consulta->update($sql, $arrData);
		if ($respuesta) {
			$respuesta = 'ok';
		}
		return $respuesta;
	}
	/*----------  Contar comites  ----------*/
	public function mdlContarComites($idMunicipalidad){
		$this->idMunicipalidad = $idMunicipalidad;
		$sql = "SELECT COUNT(idComite) AS total, SUM(CASE WHEN estadoComite = TRUE THEN 1 ELSE 0 END) AS cantidad FROM comites 
			INNER JOIN localidades ON idLocalidadComite = idLocalidad 
    		WHERE estadoLocalidad = TRUE AND idMunicipalidad = $this->idMunicipalidad";
		$respuesta = $this->consulta->select($sql);
		return $respuesta;
	}

	/*----------  mostrar cmb comites  ----------*/
	public function mdlMostrarComitesLocal($idMunicipalidad, $idLocalidad){
		$this->idMunicipalidad = $idMunicipalidad;
		$this->idLocalidad = $idLocalidad;
		$sql = "SELECT idComite as valor, nombreComite as nombre  FROM comites 
			INNER JOIN localidades ON comites.idLocalidadComite = localidades.idLocalidad
    		WHERE idMunicipalidad = $this->idMunicipalidad AND idLocalidadComite = $this->idLocalidad AND estadoComite = TRUE ORDER BY nombreComite ASC";
		$respuesta = $this->consulta->selectAll($sql);
		return $respuesta;
	}

	public function mdlTotalComites($idMunicipalidad, $estado){
		$this->idMunicipalidad = $idMunicipalidad;
		$sql = "SELECT COUNT(idComite) AS total FROM comites
	    	INNER JOIN localidades ON idLocalidadComite = idLocalidad 
			WHERE estadoComite = $estado AND idMunicipalidad = $this->idMunicipalidad";
		$respuesta = $this->consulta->select($sql);
		return $respuesta;	
		}
}