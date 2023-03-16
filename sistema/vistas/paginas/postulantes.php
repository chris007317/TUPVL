<?php
  $datosDepartamentos = ControladorDireccion::ctrMostrarDepartamentos();
  $datosTipoLocalidad = ControladorLocalidad::ctrMostrarLocalidadesActivas($_SESSION['idMunicipalidadPvl']);  
?>
<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
         <div class="col-sm-10">
          <h1 >Postulantes</h1>
          <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box bg-azul">
                <span class="info-box-icon text-dark"><i class="fas fa-users"></i></span>
                <div class="info-box-content text-white">
                  <span class="info-box-text">Solicitudes recibidas</span>
                  <span class="info-box-number"><?php echo number_format($totalPostulante['total']); ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box bg-azul">
                <span class="info-box-icon text-dark"><i class="fas fa-user-check"></i></span>
                <div class="info-box-content text-white">
                  <span class="info-box-text">Solicitudes aceptadas</span>
                  <span class="info-box-number" id="activos"></span>
                  <div class="progress">
                    <div class="progress-bar" id="porcentaje"></div>
                  </div>
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
                  <span class="info-box-text">Solicitudes rechazadas</span>
                  <span class="info-box-number" id="rechazado"></span>
                  <div class="progress">
                    <div class="progress-bar" id="porcentajes"></div>
                  </div>
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
            <li class="breadcrumb-item active">Postulantes</li>
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
                  <input type="date" class="form-control" name="dateFechaInicio" min="2020-01-01" max="<?php echo date('Y-m-d'); ?>" required="">
                </div>
                <div class="form-group mr-1">
                  <input type="date" class="form-control" name="dateFechaFin" max="<?php echo date('Y-m-d'); ?>" required="">                  
                </div>
                <div class="form-group mr-1">
                  <select class="form-control" id="cmbEstadoPostulantes">
                    <option value="">Seleccione una opción</option>
                    <option value="1">postulantes recibidos</option>
                    <option value="2">Postulantes aceptados</option>
                    <option value="0">Postulantes rechazados</option>
                  </select>
                </div>
                <div class="form-group mr1" >
                  <button class="btn btn-info" id="btnBuscarFechas">Buscar</button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-striped dt-responsive" id="tablaPostulantes" width="100%">
                <thead style="font-size: 13px">
                  <tr>
                    <th style="width: 15px;">#</th>
                    <th>Inscripción</th>
                    <th>Postulante</th>
                    <th>DNI</th>
                    <th>Dirección</th>
                    <th>Fecha Nac.</th>
                    <th>Sexo</th>
                    <th>Descripción</th>
                    <th>Localidad - Comité</th>
                    <th>Postula a</th>
                    <th>Parentesco</th>
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
        <input type="hidden" name="funcion" value="editarDireccion">
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

<div class="modal" id="modalPostulante">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formPostulante">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Editar inscripcion</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="card">
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Apellidos y nombres: </strong></div>
                <div class="w-60"><span id="postulanteNombre"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>DNI:</strong></div>
                <div class="w-60"><span id="postulanteDni"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Fecha Nac:</strong></div>
                <div class="w-60"><span id="fechaNacimiento"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Edad:</strong></div>
                <div class="w-60"><span id="postulanteEdad"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Postula a:</strong></div>
                <div class="w-60"><span id="postulanteTipo"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Inscripcion:</strong></div>
                <div class="w-60"><span id="postulanteInscripcion"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Estado:</strong></div>
                <div class="w-60"><span class="badge badge-warning" id="postulanteEstado"></span></div>
              </li>
            </ul>
          </div>
          <div class="form-group mb-3">
            <select class="form-control select2" name="cmbLocalidad" id="cmbLocalidad" style="width: 100%;"  required>
              <?php foreach ($datosTipoLocalidad as $key => $value): ?>
                <option value="<?php echo $value['idLocalidad']; ?>"><?php echo $value['nombreLocalidad']; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group mb-3">
            <select class="form-control select2" name="cmbComite" id="cmbComite" style="width: 100%;"  required>
            </select>
          </div>
          <div class="form-group d-sm-flex pb-0 mb-0">
            <p class="mr-3">Sexo:</p>
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
            <p>Descripción del postulante:</p>
            <textarea class="form-control" rows="4" placeholder="descripción..." name="txtDescripcionPost"></textarea>
          </div>
          <input type="hidden" name="idInscripcion" required>
          <input type="hidden" name="idPostulante" required>
          <input type="hidden" name="funcion" value="editarInscripcion">
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="modalAccionPostulante">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formAccion">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Aceptar o rechazar postulante</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="card">
            <ul class="list-group list-group-flush" id="listaPost">
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Apellidos y nombres: </strong></div>
                <div class="w-60"><span id="nombrePost"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>DNI:</strong></div>
                <div class="w-60"><span id="dniPost"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Fecha Nac:</strong></div>
                <div class="w-60"><span id="fechaNacPost"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Edad:</strong></div>
                <div class="w-60"><span id="edadPost"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Postula a:</strong></div>
                <div class="w-60"><span id="tipoPost"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Fecha Reg.:</strong></div>
                <div class="w-60"><span id="fechaReg"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Postula a:</strong></div>
                <div class="w-60"><h5><span class="badge" id="estadoPost"></span></h5></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="row w-100" id="listaReq"></div>
              </li>
            </ul>
          </div>
          <input type="hidden" name="idIns" required>
          <input type="hidden" name="idPost" required>
          <input type="hidden" name="totalReq" required>
          <input type="hidden" name="fechaReg" required>
          <input type="hidden" name="fechaNacPost" required>
          <input type="hidden" name="mesesMaximo" required>
          <input type="hidden" name="funcion" value="rechazarAceptarPost">
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" id="btnRechazarPost">Rechazar</button>
          </div>
          <div>
            <button type="submit" id="btnAprobarPost" class="btn btn-danger">Aprobar beneficiario</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

