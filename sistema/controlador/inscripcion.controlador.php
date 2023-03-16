<?php 
	Class ControladorInscripcion{
		/*----------  Mostrar el almacen de productos  ----------*/
		static public function ctrMostrarInscripcion($item, $valor){
			$respuesta = new ModeloInscripcion();
			return $respuesta->mdlMostrarInscripcion($item, $valor);
		}

		/*----------  Mostrar los requisitos  ----------*/
		static public function ctrMostrarRequisitosInscripcion($idInscripcion){ 
			$respuesta = new ModeloInscripcion();
			return $respuesta->mdlMostrarRequistosInscripcion($idInscripcion);
		}
		/*----------  editar inscripción  ----------*/
		static public function ctrEditarInscripcion($item, $valor, $idInscripcion){
			$respuesta = new ModeloInscripcion();
			$editar = $respuesta->mdlEditarInscripcion($item, $valor, $idInscripcion);	
			if($editar){
				return 'ok';
			}
		}
		static public function ctrEditarPostulante($descripcion, $sexo, $idPostulante){
			$respuesta = new ModeloInscripcion();
			$editar = $respuesta->mdlEditarPostulante($descripcion, $sexo, $idPostulante);	
			if($editar){
				return 'ok';
			}	
		}
		/*----------  contar las nuevas inscripciones  ----------*/
		static public function ctrNuevosInscritos($idMunicipalidad){
			$respuesta = new ModeloInscripcion();
			return $respuesta->mdlNuevosInscritos($idMunicipalidad);
		}
		/*----------  contar todas las inscripciones  ----------*/
		static public function ctrTotalInscritos($idMunicipalidad, $estado){
			$respuesta = new ModeloInscripcion();
			return $respuesta->mdlTotalInscritos($idMunicipalidad, $estado);
		}
		static public function ctrPorcentajeInscritos($idMunicipalidad, $estado){
			$respuesta = new ModeloInscripcion();
			return $respuesta->mdlPorcentajeInscritos($idMunicipalidad, $estado);
		}
	}