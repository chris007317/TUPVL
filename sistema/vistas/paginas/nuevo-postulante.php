<?php 
  $datosDepartamentos = ControladorDireccion::ctrMostrarDepartamentos();
  $datosTipoLocalidad = ControladorLocalidad::ctrMostrarLocalidadesActivas($_SESSION['idMunicipalidadPvl']);  
  $tipoSocio = ControladorSocio::ctrMostrarTipoSocios();
  $tipoBeneficiario = ControladorTipoBeneficiario::ctrMostrarTipoBeneficiario();
 ?>
<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="d-sm-flex">
            <h1 class="mr-2">Registros</h1>              
            <button type="button" class="btn btn-secondary btn-sm mr-1" data-toggle="modal" data-target="#verSocios" title="Ver socios">
              <i class="fas fa-eye"></i> Ver Socios
            </button>
            <button type="button" id="btnAgregarSocio" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalSocio">
              <i class="fas fa-user-plus"></i> Agregar Socio
            </button>
          </div>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Nuevo postulante</li>
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
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Datos del socio</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="col-sm-12 rounded-top p-2">
                <div class="row">
                  <div class="col-md-3 col-sm-6 col-12 pb-2">
                    <h6><b>Apellidos y nombres: </b><br>
                    <span id="nombreSocio"></span></h6>
                  </div>
                  <div class="col-md-3 col-sm-6 col-12 pb-2">
                    <h6><b>DNI: </b><br>
                    <span id="dniSocio"></span></h6>
                  </div>
                  <div class="col-md-3 col-sm-6 col-12 pb-2">
                      <h6><b>Ubicación: </b><br>
                      <span id="ubicacionSocio"></span></h6>  
                  </div>
                  <div class="col-md-3 col-sm-6 col-12 pb-2">
                      <h6 ><b>Dirección: </b><br>
                      <span id="direccionSocio"></span></h6>  
                  </div>
                </div>
              </div>
              <div class="col-sm-12 rounded-bottom p-2">
                <div class="row">
                  <div class="col-md-3 col-sm-6 col-12 pb-2">
                    <h6><b>Celular: </b><br>
                    <span id="celularSocio"></span></h6>
                  </div>
                  <div class="col-md-3 col-sm-6 col-12 pb-2">
                    <h6> <b>Correo: </b><br>
                    <span id="correoSocio"></span></h6>
                  </div>
                  <div class="col-md-3 col-sm-6 col-12">
                    <h6><b>¿El socio es Beneficiario?</b>
                      <div class="form-row">
                        <div class="custom-control custom-radio w-25">
                          <input class="custom-control-input" type="radio" id="rdBtnSi" name="rdBtnSocio">
                          <label for="rdBtnSi" class="custom-control-label">Si</label>
                        </div>
                        <div class="custom-control custom-radio w-25">
                          <input class="custom-control-input" type="radio" id="rdBtnNo" name="rdBtnSocio" checked="" value="0">
                          <label for="rdBtnNo" class="custom-control-label">No</label>
                        </div>
                      </div>
                    </h6>
                  </div>
                  <div class="col-md-3 col-sm-6 col-12"> 
                    <h6 ><b>Otros:</b> 
                    <div>
                      <button class="btn btn-azul btn-sm" id="btnLimpiarSocio"><i class="fas fa-trash-alt"></i> Limpiar</button>
                    </div></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Datos del postulante</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <form id="formPostulante" method="POST">
                <div class="col-sm-12 d-sm-flex p-0">
                  <div class="col-md-6 col-sm-6 col-12 p-2">
                    <div class="row">
                      <div class="form-group col-md-6 mb-3">
                        <label>DNI *</label>
                        <div class="input-group">
                          <input type="text" class="form-control mr-1" maxlength="8" minlength="8" placeholder="DNI" name="txtDniPostulante">
                          <button type="button" class="btn btn-info" id="buscarPostulante">Buscar</button>
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Apellido Paterno *</label>
                        <input type="text" placeholder="Apellido paterno" class="form-control" name="txtApellidoPaternoPost" readonly>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label>Apellido Materno *</label>
                        <input type="text" placeholder="Apellido materno" class="form-control" name="txtApellidoMaternoPost" readonly>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Nombres *</label>
                        <input type="text" placeholder="Apellido materno" class="form-control" name="txtNombresPost" readonly>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label>Departamento *</label>
                        <select class="form-control select2" name="cmbDepartamentoPost" id="cmbDepartamentoPost" style="width: 100%;"  required>
                          <option value="">Elija una opcion</option>
                          <?php foreach ($datosDepartamentos as $key => $value): ?>
                            <option value="<?php echo $value['idDepartamento']; ?>"><?php echo $value['nombreDepartamento']; ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Provincia *</label>
                        <select class="form-control select2" name="cmbProvinciaPost" id="cmbProvinciaPost" style="width: 100%;"  disabled required></select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label>Distrito</label>
                        <select class="form-control select2" name="cmbDistritoPost" id="cmbDistritoPost" style="width: 100%;" disabled  required>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Sexo *</label>
                        <div class="form-row">
                          <div class="custom-control custom-radio mr-3">
                            <input class="custom-control-input" type="radio" id="radMasculino" name="customRadio" value="F">
                            <label for="radMasculino" class="custom-control-label">Femenino</label>
                          </div>
                          <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="radFemenino" name="customRadio" value="M">
                            <label for="radFemenino" class="custom-control-label">Masculino</label>
                          </div>
                        </div>
                      </div>    
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label>Dirección *</label>
                        <input type="text" class="form-control" name="txtDireccionPostulante" placeholder="Dirección" >
                      </div>
                      <div class="form-group col-md-6">
                        <label>Número *</label>
                        <input type="text" class="form-control" name="txtNumeroDirPostulante" placeholder="#">
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label>Descripción de la dirección **</label>
                        <textarea class="form-control" rows="3" placeholder="descripción..." name="txtDescripcionDirPost" maxlength="254" ></textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label>Descripción del postulante **</label>
                        <textarea class="form-control" rows="3" placeholder="descripción..." name="txtDescripcionPost" maxlength="254"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-12 p-2">
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label>Fecha de nacimiento *</label>
                        <input type="date" class="form-control" name="dateFechaNac" max="<?php echo date('Y-m-d'); ?>" required readonly> 
                      </div> 
                      <div class="form-group col-md-6">
                        <label>Edad:*</label>
                        <h5><span class="badge badge-info" id="edadPostulante"></span></h5>
                      </div>  
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label>Parentesco con el socio *</label>
                        <select class="form-control select2" name="tipoSocioPost" id="" style="width: 100%;"  required>
                          <option value="">Elija una opcion</option>
                          <?php foreach ($tipoSocio as $key => $value): ?>
                            <option value="<?php echo $value['idTipoSocio']; ?>"><?php echo $value['nombreTipoSocio']; ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Fecha de inscripción *</label>
                        <input type="datetime-local" class="form-control" name="dateFechaRegistro" id="dateFechaRegistro" required readonly> 
                      </div> 
                    </div>
                    <hr>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label>Localidad *</label>
                        <select class="form-control select2" name="cmbTipoLocalidadPost" id="cmbTipoLocalidadPost" style="width: 100%;"  required>
                          <option value="">Elija una opcion</option>
                          <?php foreach ($datosTipoLocalidad as $key => $value): ?>
                            <option value="<?php echo $value['idLocalidad']; ?>"><?php echo $value['nombreLocalidad']; ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Comité *</label>
                        <select class="form-control select2" name="cmbComitesPost" id="cmbComitesPost" style="width: 100%;" required="" disabled></select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label>Tipo de beneficiario *</label>
                        <select class="form-control select2" name="cmbTipoPostulante" id="cmbTipoPostulante" style="width: 100%;"  required>
                          <option value="">Elija una opcion</option>
                          <?php foreach ($tipoBeneficiario as $key => $value): ?>
                            <option value="<?php echo $value['idTipoBeneficiario']; ?>" inicioEdad="<?php echo $value['inicioEdad']; ?>" finEdad="<?php echo $value['finEdad']; ?>"><?php echo $value['nombreTipoBeneficiario']; ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Resultado</label>
                        <h5><span id="valReg" class="badge badge-danger">Invalido</span></h5>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label>Requisitos *</label>
                        <div id="requisitos">                          
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Total de requisitos: <span id="totalRequisitos"></span></label>
                        <h5><span class="badge badge-info" id="numRequisitos"></span></h5>
                      </div>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="totalReq" required>
                <input type="hidden" name="idSocioPostulante" required>
                <input type="hidden" name="idPersonaPostulante">
                <input type="hidden" name="idDireccionPostulante">
                <input type="hidden" name="idPost" >
                <div class="w-100">
                  <button type="submit" class="btn btn-primary float-right ml-2" id="btnRegistrarPostulante"><i class="fas fa-save"></i> Guardar</button>                  
                  <button type="button" class="btn btn-dark float-right mr-2" id="btnCancelarPost"><i class="fas fa-times"></i> Cancelar</button>
                </div>
                <?php 
                  $registrarPostulante = new ControladorPostulante();
                  $registrarPostulante->ctrRegistrarPostulante();
                ?>
              </form>
            </div>
            <div class="card-footer p-0 pl-2">
              <p class="text-dark">(*) Campos obligartorios <br>
              (**) Campos no obligarorios</p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>

<div class="modal" id="verSocios">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header bg-light">
        <h4 class="modal-title">Socios Registrados</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <table class="table table-bordered table-striped dt-responsive" id="tablaSocios" width="100%">
            <thead>
              <tr>
                <th style="width: 15px">#</th>
                <th>Socio</th>
                <th>DNI</th>
                <th>Dirección</th>
                <th>Referencia</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalSocio">
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
            <select class="form-control select2" name="cmbDepartamentoDir" id="cmbDepartamentoDir" style="width: 100%;"  required>
              <option value="">Seleccione un departamento</option>
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
              <input type="text" class="form-control" name="txtNumeroDir" min="0" placeholder="#" pattern="[0-9]+"> 
            </div>
          </div>
          <div class="form-group">
            <p>Escriba una descripción acerca de la dirección:</p>
            <textarea class="form-control" rows="4" placeholder="descripción..." name="txtDescripcionDir" maxlength="254"></textarea>
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
        <input type="hidden" name="idPersonaSocio" required>
        <input type="hidden" name="idDireccionSocio" required>
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