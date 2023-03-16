<?php 
    $departamento = ControladorInscripcion::ctrMostrarDepartamento();
 ?>
		<div class="contenedor">
			<div class="titulo-descripcion">
				<div class="ancho-100 text-center pd-top-10 pd-bottom-10">
					<h2>Ingrese los datos de su municipalidad</h2>
				</div>
				<p>Mediante esta plataforma podra registrar la municiapalidad que se encuentre a su cargo, para la gestión del programa de vaso de leche.</p>	
				<p>* Campos obligatorios</p>
			</div>
			<div class="form-inscripcion center mr-bottom-15">
				<form method="post" id="inscribirMuniciaplidad" enctype="multipart/form-data">
					<div class="inscripcion-cuerpo">
						<div class="card">
							<div class="card-titulo">
								<h3>Municipalidad</h3>
							</div>
							<div class="input-grupo">
								<label>Departamento *</label>
								<select name="cmbDepartamentos" id="cmbDepartamentos" required>
									<option value="" class="selector">Elija una opcion</option>
									<?php foreach ($departamento as $key => $value): ?>
										<option value="<?php echo $value['idDepartamento'] ?>" class="selector"><?php echo $value['nombreDepartamento'] ?></option>	
									<?php endforeach ?>
								</select>
							</div>
							<div class="input-grupo">
								<label>Provincia *</label>
								<select name="cmbProvincias" id="cmbProvincias" disabled required></select>
							</div>
							<div class="input-grupo">
								<label>Distrito *</label>
								<select name="cmbDistritos" id="cmbDistritos" disabled required></select>
							</div>
							<div class="input-grupo">
								<label for="txtRuc">Número de RUC *</label>
								<input type="text" name="txtRuc" id="txtRuc" minlength="11" maxlength="11" pattern="[0-9]+" required>
							</div>
							<div class="input-grupo">
								<label>Nombre de la municipalidad *</label>
								<input type="text" name="txtNombreMunicipalidad" id="txtNombreMunicipalidad" pattern="[ A-Za-z0-9äÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙÑñ.-]+" required>
							</div>
							<div class="input-grupo">
								<label>Dirección fiscal de la municiaplaidad *</label>
								<input type="text" name="txtDireccionMunicipalidad" id="txtDireccionMunicipalidad" pattern="[ A-Za-z0-9äÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙÑñ°#.-]+" required>
							</div>
							<div class="input-grupo">
								<label>Logo de la municipalidad</label>
								<input type="file" name="logoMunicipalidad">
							</div>
						</div>
						<div class="card">
							<div class="card-titulo">
								<h3>Responsable de la municipalidad</h3>
							</div>
							<div class="input-grupo">
								<label for="txtDniResponsable" >DNI *</label>
								<input type="text" name="txtDniResponsable" id="txtDniResponsable" minlength="8" maxlength="8" required>
							</div>
							<div class="input-grupo">
								<label for="txtApellidoPaterno" >Apellido Paterno *</label>
								<input type="text" name="txtApellidoPaterno" id="txtApellidoPaterno" disabled required>
							</div>
							<div class="input-grupo">
								<label for="txtApellidoMaterno">Apellido Materno *</label>
								<input type="text" name="txtApellidoMaterno" id="txtApellidoMaterno" disabled required>
							</div>
							<div class="input-grupo">
								<label for="txtNombres">nombres *</label>
								<input type="text" name="txtNombres" id="txtNombres" disabled required>
							</div>
							<div class="input-grupo">
								<label for="txtCorreoResponsable">Correo *</label>
								<input type="eamil" name="txtCorreoResponsable" id="txtCorreoResponsable" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
							</div>
							<div class="input-grupo">
								<label for="txtCelularResponsable">Celular *</label>
								<input type="text" name="txtCelularResponsable" id="txtCelularResponsable" minlength="9" maxlength="9" pattern="[0-9]+" required>
							</div>
						</div>
						<a href="" class="menu-link pd-bottom-5">Ver terminos y condiciones</a>
						<div class="mr-bottom-15 check">
							<input id="option" type="checkbox" name="checkCondiciones">
    						<label for="option">Acepto los terminos y condiciones</label>
						</div>
						<input type="hidden" name="funcion" value="registrarInscripcion">
						<button class="btn btn-largo btn-rosa btn-inscripcion" type="submit">Enviar</button>
					</div>
				</form>
			</div>
		</div>