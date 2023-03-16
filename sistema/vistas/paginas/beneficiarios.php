<?php
  $datosDepartamentos = ControladorDireccion::ctrMostrarDepartamentos();
  $datosTipoLocalidad = ControladorLocalidad::ctrMostrarLocalidadesActivas($_SESSION['idMunicipalidadPvl']);  
  $tipoSocio = ControladorSocio::ctrMostrarTipoSocios();
  $comites = ControladorComite::ctrMostrarComites($_SESSION['idMunicipalidadPvl']);
  $estadoBenef = ControladorBeneficiario::ctrMostrarEstadoBeneficiario();
  $totalBeneficiarios = $datosBenef->ctrTotalBeneficiarios($_SESSION['idMunicipalidadPvl'], 1);
?>
<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
         <div class="col-sm-10">
          <h1 >Beneficiarios</h1>
          <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box bg-azul">
                <span class="info-box-icon text-dark"><i class="fas fa-users"></i></span>
                <div class="info-box-content text-white">
                  <span class="info-box-text">Beneficiarios activos</span>
                  <span class="info-box-number"><?php echo number_format($totalBeneficiarios['total']); ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box bg-azul">
                <span class="info-box-icon text-dark"><i class="fas fa-user-times"></i></span>
                <div class="info-box-content text-white">
                  <span class="info-box-text">Beneficiarios por vencer</span>
                  <span class="info-box-number"><?php echo number_format($porVencer['total']); ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <!-- /.col -->
          </div>
        </div>
        <div class="col-sm-2">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Beneficiarios</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Default box -->
          <div class="card card-danger card-outline">
            <div class="card-header pb-0">
              <div class="row">
                <div class="form-group mr-1">
                  <select class="form-control select2"  id="cmbLocalidadBenef">
                    <option value="">Seleccione localidad</option>
                    <option value="0">Ver todos las localidades</option>
                    <?php foreach ($datosTipoLocalidad as $key => $value): ?>
                      <option value="<?php echo $value['idLocalidad']; ?>"><?php echo $value['nombreLocalidad']; ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group mr-1">
                  <select class="form-control select2" name="cmbComiteBenef" id="cmbComiteBenef" disabled>
                    <option value="">Seleccione un Comité</option>
                  </select>
                </div>
                <div class="form-group mr-1" >
                  <button class="btn btn-jade" id="btnVerBeneficiarios"><i class="fas fa-eye"></i> Ver</button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="form-group mr-1">
                  <input type="date" class="form-control" name="dateFechaInicio" min="2020-01-01" max="<?php echo date('Y-m-d'); ?>" required="">
                </div>
                <div class="form-group mr-1">
                  <input type="date" class="form-control" name="dateFechaFin" max="<?php echo date('Y-m-d'); ?>" required="">                  
                </div>
                <div class="form-group mr-1">
                  <select class="form-control" id="cmbEstadoPostulantes">
                    <option value="">Seleccione el estado</option>
                    <?php foreach ($estadoBenef as $key => $value): ?>
                      <option value="<?php echo $value['idEstadoBeneficiario']; ?>"><?php echo $value['nombreEstadoBeneficiario']; ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group mr1" >
                  <button class="btn btn-jade" id="btnBuscarFechas">Buscar</button>
                </div>
              </div>
              <table class="table table-bordered table-striped dt-responsive" id="tablaBeneficiarios" width="100%">
                <thead style="font-size: 13px">
                  <tr>
                    <th style="width: 15px;">#</th>
                    <th>Inscripción</th>
                    <th>Beneficiario</th>
                    <th>DNI</th>
                    <th>Dirección</th>
                    <th>Fecha Nac.</th>
                    <th>Sexo</th>
                    <th>Localidad - Comité</th>
                    <th>Tipo Benef</th>
                    <th>Parentesco</th>
                    <th>Tiempo Rest.</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody style="font-size: 13px">
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              Footer
            </div>
            <!-- /.card-footer-->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>

<div class="modal" id="modalDireccion">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formDireccion">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-address-card"></span>
            </div>
            <input type="text" class="form-control" name="txtPostulante" placeholder="Apellidos y nombres" disabled> 
          </div>
          <div class="form-group mb-3">
            <select class="form-control select2" name="cmbDepartamentoDir" id="cmbDepartamentoDir" style="width: 100%;"  required>
              <option value="">Elija una opcion</option>
              <?php foreach ($datosDepartamentos as $key => $value): ?>
                <option value="<?php echo $value['idDepartamento']; ?>"><?php echo $value['nombreDepartamento']; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group mb-3">
            <select class="form-control select2" name="cmbProvinciaDir" id="cmbProvinciaDir" style="width: 100%;"  disabled required>
            </select>
          </div>
          <div class="form-group mb-3">
            <select class="form-control select2" name="cmbDistritoDir" id="cmbDistritoDir" style="width: 100%;" disabled  required>
            </select>
          </div>
          <hr class="">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-map-marker-alt"></span>
            </div>
            <input type="text" class="form-control" name="txtDireccion" placeholder="Dirección" required> 
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-mobile-alt"></span>
            </div>
            <input type="text" class="form-control" name="txtNumeroDir" min="0" placeholder="Número de dirección"> 
          </div>
          <div class="form-group">
            <p>Escriba una descripción acerca de la dirección:</p>
            <textarea class="form-control" rows="4" placeholder="descripción..." name="txtDescripcionDir"></textarea>
          </div>
        </div>
        <input type="hidden" name="idPersona">
        <input type="hidden" name="idDireccion">
        <input type="hidden" name="funcion">
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">Agregar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="modalSocio">
  <div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header bg-info">
          <h4 class="modal-title">Socio inscrito</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="card m-0">
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Apellidos y nombres: </strong></div>
                <div class="w-60"><span id="socioNombre"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>DNI:</strong></div>
                <div class="w-60"><span id="socioDni"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Ubicación:</strong></div>
                <div class="w-60"><span id="socioUbicacion"></span></div>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Dirección:</strong></div>
                <div class="w-60"><span id="socioDireccion"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Celular:</strong></div>
                <div class="w-60"><span id="socioCelular"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Correo:</strong></div>
                <div class="w-60"><span id="socioCorreo"></span></div>
              </li>
            </ul>
          </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
    </div>
  </div>
</div>

<div class="modal" id="cambiarSocio">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formSocio">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Agregar Socio</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="d-inline-flex w-75 pr-2">
              <div class="input-group-append input-group-text">
                <span class="fas fa-address-card"></span>
              </div>
              <input type="text" class="form-control" name="txtDniSocio" placeholder="Número de DNI" maxlength="8" minlength="8" pattern="[0-9]+" required autofocus> 
            </div>
            <button type="button" class="btn btn-info w-25" id="btnBuscarSocio">Buscar</button>
          </div>
          <div class="alert text-center alert-danger" id="alertaDniSocio" style="display: none;">
            <span></span>
          </div>
          <div class="alert text-center alert-info" id="alertaDniSocio1" style="display: none;">
            <span></span>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <input type="text" class="form-control" name="txtApellidoPaterno" placeholder="Apellido Paterno" readonly required>
            </div>
            <div class="form-group col-md-6">
              <input type="text" class="form-control" name="txtApellidoMaterno" placeholder="Apellido Materno" readonly required>
            </div>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="txtNombreSocio" placeholder="Nombres" readonly required>
          </div>
          <hr>
          <div class="form-group mb-3">
            <select class="form-control select2" name="cmbDepartamentoSocio" id="cmbDepartamentoSocio" style="width: 100%;"  required>
              <option value="">Seleccione un departamento</option>
              <?php foreach ($datosDepartamentos as $key => $value): ?>
                <option value="<?php echo $value['idDepartamento']; ?>"><?php echo $value['nombreDepartamento']; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group mb-3">
            <select class="form-control select2" name="cmbProvinciaSocio" id="cmbProvinciaSocio" style="width: 100%;"  disabled required>
            </select>
          </div>
          <div class="form-group mb-3">
            <select class="form-control select2" name="cmbDistritoSocio" id="cmbDistritoSocio" style="width: 100%;" disabled  required>
            </select>
          </div>
          <hr>
          <div class="form-row">
            <div class="input-group col-md-9 mb-3">
              <div class="input-group-append input-group-text">
                <span class="fas fa-map-marker-alt"></span>
              </div>
              <input type="text" class="form-control" name="txtDireccionSocio" placeholder="Dirección" required> 
            </div>
            <div class="input-group col-md-3 mb-3">
              <div class="input-group-append input-group-text">
                <span class="fas fa-hashtag"></span>
              </div>
              <input type="text" class="form-control" name="txtNumeroDirSocio" min="0" placeholder="#" pattern="[0-9]+"> 
            </div>
          </div>
          <div class="form-group">
            <p>Escriba una descripción acerca de la dirección:</p>
            <textarea class="form-control" rows="4" placeholder="descripción..." name="txtDescripcionDirSocio" maxlength="254"></textarea>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-at"></span>
            </div>
            <input type="email" class="form-control" name="txtCorreoSocio" placeholder="Correo"> 
          </div>
          <div class="input-group">
            <div class="input-group-append input-group-text">
              <span class="fas fa-mobile-alt"></span>
            </div>
            <input type="text" class="form-control" name="txtCelularSocio" minlength="9" maxlength="9" pattern="[0-9]+" placeholder="Número de celular"> 
          </div>
        </div>
        <input type="hidden" name="idPersonaSocio">
        <input type="hidden" name="idDireccionSocio">
        <input type="hidden" name="idSocio" >
        <input type="hidden" name="idBeneficiario">
        <input type="hidden" name="funcion" required>
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">Agregar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="verBeneficiario">
  <div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Detalles del postulante</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="card mb-0 pb-0">
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Apellidos y nombres: </strong></div>
                <div class="w-60"><span id="beneficiarioNombre"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>DNI:</strong></div>
                <div class="w-60"><span id="benficiarioDni"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Fecha Nac:</strong></div>
                <div class="w-60"><span class="badge badge-info" id="fechaNacimiento"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Edad:</strong></div>
                <div class="w-60"><span class="badge badge-info" id="beneficiarioEdad"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Tipo Benef:</strong></div>
                <div class="w-60"><span id="beneficiarioTipo"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Parentesco:</strong></div>
                <div class="w-60"><span id="beneficiarioParen"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Sexo:</strong></div>
                <div class="w-60"><span id="beneficiarioSexo"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Registrado:</strong></div>
                <div class="w-60"><span id="beneficiarioReg"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Fecha Ven:</strong></div>
                <div class="w-60"><span class="badge badge-info" id="fechaVencimiento"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Tiempo Res:</strong></div>
                <div class="w-60"><span class="badge" id="tiempoRes"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Localidad - Comité:</strong></div>
                <div class="w-60"><span id="beneficiarioLocal"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Estado:</strong></div>
                <div class="w-60"><span class="badge" id="beneficiarioEstado"></span></div>
              </li>
            </ul>
          </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
  </div>
</div>

<div class="modal" id="editarBeneficiario">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formEditarBenef">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Editar beneficiario</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="card">
            <ul class="list-group list-group-flush" id="listaPost">
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Apellidos y nombres: </strong></div>
                <div class="w-60"><span id="nombreBenef"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>DNI:</strong></div>
                <div class="w-60"><span id="dniBenef"></span></div>
              </li>
            </ul>
          </div>
            <div class="form-group">
              <label>Parentesco con el socio:</label>
              <select class="form-control " name="cmbParentesco" id="cmbParentesco" style="width: 100%;"  required>
                <?php foreach ($tipoSocio as $key => $value): ?>
                  <option value="<?php echo $value['idTipoSocio']; ?>"><?php echo $value['nombreTipoSocio']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <label>Comté:</label>
              <select class="form-control " name="cmbComite" id="cmbComite" style="width: 100%;"  required>
                <?php foreach ($comites as $key => $value): ?>
                  <option value="<?php echo $value['idComite']; ?>"><?php echo $value['nombreComite']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <label>Estado del beneficiario:</label>
              <select class="form-control " name="cmbEstadoBenef" id="cmbEstadoBenef" style="width: 100%;"  required>
                <?php foreach ($estadoBenef as $key => $value): ?>
                  <option value="<?php echo $value['idEstadoBeneficiario']; ?>"><?php echo strtoupper($value['nombreEstadoBeneficiario']); ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group d-sm-flex">
              <label class="mr-3">Sexo:</label>
              <div class="custom-control custom-radio mr-3">
                <input class="custom-control-input" type="radio" id="radMasculino" name="customRadio" value="F">
                <label for="radMasculino" class="custom-control-label">Femenino</label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" id="radFemenino" name="customRadio" value="M">
                <label for="radFemenino" class="custom-control-label">Masculino</label>
              </div>
            </div>
            <div class="form-group">
              <label>Descripción del beneficiario:</label>
              <textarea class="form-control" name="txtDescripcionBenef" rows="4" maxlength="254"></textarea>
            </div>
            <input type="hidden" name="idInscripcion" value="" required>
            <input type="hidden" name="idPostulante" value="" required>
            <input type="hidden" name="fechaRg" value="" required>
            <input type="hidden" name="fechaVen" value="" required>
            <input type="hidden" name="estadoBen" value="" required>
          <input type="hidden" name="funcion" value="editarBeneficiario">
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" id="btnEditarBeneficiario" class="btn btn-danger">Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

