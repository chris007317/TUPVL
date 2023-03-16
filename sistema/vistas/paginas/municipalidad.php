<?php 
  $datosMuni = ControladorMunicipalidad::ctrMostrarMunicipalidad($_SESSION['idMunicipalidadPvl']);  
  
  $datosTipoBeneficiario = ControladorTipoBeneficiario::ctrMostrarTipoBeneficiario();  
  $datosRequsitos = ControladorRequisitos::ctrMostrarRequisitos();  
  $datosTipoLocalidad = ControladorLocalidad::ctrMostrarTipoLocalidad();  
  $cantidadComites = ControladorComite::ctrContarComite($_SESSION['idMunicipalidadPvl']);
  $totalBeneficiarios = $datosBenef->ctrTotalBeneficiarios($_SESSION['idMunicipalidadPvl'], 1);
  $totalSocios = ControladorSocio::ctrTotalSocios($_SESSION['idMunicipalidadPvl'], 1);
        
 ?>
<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Configuración de la Municipalidad</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Municipalidades</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-danger card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="<?php echo $rutaSistema.'vistas/'.$datosMuni['imagenMunicipalidad']; ?>" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php  echo $datosMuni['nombreMunicipalidad']; ?></h3>

                <p class="text-muted text-center"><?php echo mb_strtoupper($datosMuni['nombreDistrito'].', '.$datosMuni['nombreProvincia'].', '.$datosMuni['nombreDepartamento'], 'UTF-8'); ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Comités</b> <a class="float-right"><?php echo $cantidadComites['total']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Beneficiarios</b> <a class="float-right"><?php echo $totalBeneficiarios['total']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Socios</b> <a class="float-right"><?php echo $totalSocios['total']; ?></a>
                  </li>
                </ul>
                <button class="btn btn-outline-danger btn-block" id="btnEditarImgMuni" idMunicipalidad="<?php echo $datosMuni['idMunicipalidad'] ?>" data-toggle="modal" data-target="#editarImagenMuni">Editar imagen</button>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Datos</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> RUC</strong>

                <p class="text-muted"><?php echo $datosMuni['ruc']; ?></p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Dirección</strong>

                <p class="text-muted"><?php echo $datosMuni['direccionMunicipalidad']; ?></p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Hora de Entrada</strong>

                <p class="text-muted"><?php echo $datosMuni['horaEntrada']; ?></p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Hora de Salida</strong>

                <p class="text-muted"><?php echo $datosMuni['horaSalida']; ?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#requisitos" id="requisitosTitle" data-toggle="tab">Requisitos</a></li>
                  <li class="nav-item"><a class="nav-link" href="#localidades" id="localidadesTitle" data-toggle="tab">Localidades</a></li>
                  <li class="nav-item"><a class="nav-link" href="#horario" data-toggle="tab">Horario</a></li>
                  <li class="nav-item"><a class="nav-link" href="#periodos" data-toggle="tab">Periodos</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane" id="horario">
                    <form class="form-horizontal" method="post">
                      <div class="form-group row">
                        <label for="horaEntrada" class="col-sm-2 col-form-label">Hora Entrada</label>
                        <div class="col">
                          <input type="time" class="form-control" name="horaEntrada" value="<?php echo $datosMuni['horaEntrada']; ?>" min="06:00" max="18:00" required>
                        </div>
                        <label for="horaSalida" class="col-sm-2 col-form-label">Hora Salida</label>
                        <div class="col">
                          <input type="time" class="form-control" name="horaSalida" value="<?php echo $datosMuni['horaSalida']; ?>" min="06:00" max="23:59" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="w-100 text-center">
                          <button type="submit" class="btn btn-primary w-50 ">Editar Horario</button>
                        </div>
                      </div>
                      <?php 
                        $editarMuni = new ControladorMunicipalidad();
                        $editarMuni->ctrEditarHorario()
                       ?>
                    </form>
                  </div>
                  <div class="tab-pane" id="periodos">
                    <form class="form-horizontal" method="post">
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Entrega cada: </label>
                        <div class="col">
                          <select class="form-control" name="cmbPeriodo" id="cmbPeriodo" required>
                            <option value="">Seleccione opción</option>
                            <option value="1">1 mes</option>
                            <option value="2">2 meses</option>
                            <option value="3">3 meses</option>
                            <option value="4">4 meses</option>
                            <option value="6">6 meses</option>
                          </select>
                        </div>
                        <label for="yearPeriodo" class="col-sm-2 col-form-label">Año: </label>
                        <div class="col">
                          <input type="number" class="form-control" name="yearPerido" value="<?php echo date("Y"); ?>" readonly required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="w-100 text-center">
                          <button type="submit" class="btn btn-primary">Guardar periodo</button>
                        </div>
                      </div>
                      <?php 
                        $editarMuni = new ControladorMunicipalidad();
                        $editarMuni->ctrRegistrarPeriodoMunicipalidad();
                       ?>
                    </form>
                    <div class="table-responsive">
                      <table class="table table-sm">
                          <thead>
                            <tr>
                              <th style="width: 40px">#</th>
                              <th>Meses por periodo</th>
                              <th>Entregas</th>
                              <th>Año</th>
                              <th>Estado</th>
                            </tr>
                          </thead>
                          <tbody id="tablaPeriodos">
                          </tbody>
                      </table>
                    
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="active tab-pane" id="requisitos">
                    <div class="form-group d-sm-flex">
                      <button class="btn btn-info m-1" data-toggle="modal" data-target="#agregarRequisitoTipoBenef">Añadir requisito</button>
                      <div class="m-1">
                        <select class="form-control" name="cmbTipoBeneficiarios" id="cmbTipoBeneficiarios" required>
                          <?php foreach ($datosTipoBeneficiario as $key => $value): ?>
                            <option value="<?php echo $value['idTipoBeneficiario']; ?>"><?php echo $value['nombreTipoBeneficiario']; ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-sm">
                          <thead>
                            <tr>
                              <th style="width: 40px">#</th>
                              <th>Requisito</th>
                              <th>Descripción</th>
                              <th>Estado</th>
                              <th style="width:40px">Acciones</th>
                            </tr>
                          </thead>
                          <tbody id="cuerpoTablaRequisitos">
                          </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- tab pane -->
                  <div class="tab-pane" id="localidades">
                    <div class="form-group d-sm-flex">
                      <button class="btn btn-info m-1" data-toggle="modal" data-target="#agregarLocalidad">Añadir localidad</button>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-sm">
                          <thead>
                            <tr>
                              <th style="width: 40px">#</th>
                              <th>Localidad</th>
                              <th>Tipo</th>
                              <th>Estado</th>
                              <th style="width:40px">Acciones</th>
                            </tr>
                          </thead>
                          <tbody id="cuerpoTablaLocalidad">
                          </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  <!-- /.content -->
</div>

<!-- agregar nuevo requisito para una municipalidad -->
<div class="modal" id="agregarRequisitoTipoBenef">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Agregar requisito</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-list-ul"></span>
            </div>
            <select class="form-control" name="cmbAgregarTipoBenef" id="cmbAgregarTipoBenef" required>
              <option value="">Seleccion el tipo de beneficiario</option>
                <?php foreach ($datosTipoBeneficiario as $key => $value): ?>
                  <option value="<?php echo $value['idTipoBeneficiario']; ?>"><?php echo $value['nombreTipoBeneficiario']; ?></option>
                <?php endforeach ?>
            </select>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-list-ul"></span>
            </div>
            <select class="form-control" name="cmbAgregarRequisitoBenef" id="cmbAgregarRequisitoBenef" required>
              <option value="">Seleccion el requisito</option>
                <?php foreach ($datosRequsitos as $key => $value): ?>
                  <option value="<?php echo $value['idRequisito']; ?>"><?php echo $value['nombreRequisito']; ?></option>
                <?php endforeach ?>              
            </select>
          </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer ">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">Agregar</button>
          </div>
        </div>
        <?php
          $registrarRequisito = new ControladorRequisitoMunicipalidad();
          $registrarRequisito->ctrRegistrarRequisitoMunicipalidad();
        ?>
      </form>
    </div>
  </div>
</div>

<!-- Editar imagen -->
<div class="modal" id="editarImagenMuni">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data">
        <div class="modal-header bg-light">
          <h4>Editar imagen de la municipalidad</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="idMunicipalidad" >
          <input type="hidden" name="imgActualMuni" >
          <div class="input-group my-2">
            <input type="file" class="form-control-file border" name="imgEditarMuni"  required>
            <p class="help-block small">Dimenciones: 480 * 382px | Peso max. 2MB | Formato: JPG o PNG</p>
            <img class="img-fluid" id="previsualizarMuni">
          </div>
        </div>
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </div>
        <?php 
          $editarMuni->ctrEditarImgMuni()
         ?>
      </form>
    </div>
  </div>
</div>

<!-- agregar nuevo localidad para una municipalidad -->
<div class="modal" id="agregarLocalidad">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formAgregarLocalidad">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title" id="btnAgregarLocalidad">Agregar localidad</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-list-ul"></span>
            </div>
            <select class="form-control" name="cmbAgregarLocalidad" id="cmbAgregarLocalidad" required>
              <option value="">Seleccion el tipo localidad</option>
                <?php foreach ($datosTipoLocalidad as $key => $value): ?>
                  <option value="<?php echo $value['idTipoLocalidad']; ?>"><?php echo $value['nombreTipoLocalidad']; ?></option>
                <?php endforeach ?>
            </select>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-list-ul"></span>
            </div>
            <input type="text" class="form-control" name="txtAgregarLocalidad" placeholder="Ingrese nombre de la localidad" required>
          </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer ">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">Agregar</button>
          </div>
        </div>
        <?php
          $agregarLocalidad = new ControladorLocalidad();
          $agregarLocalidad->ctrAgregarlocalidad();
        ?>
      </form>
    </div>
  </div>
</div>

<!-- agregar nuevo localidad para una municipalidad -->
<div class="modal" id="editarLocalidad">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formEditarLocalidad">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Editar localidad</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-list-ul"></span>
            </div>
            <select class="form-control" name="cmbEditarLocalidad" id="cmbEditarLocalidad" required>
                <?php foreach ($datosTipoLocalidad as $key => $value): ?>
                  <option value="<?php echo $value['idTipoLocalidad']; ?>"><?php echo $value['nombreTipoLocalidad']; ?></option>
                <?php endforeach ?>
            </select>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-list-ul"></span>
            </div>
            <input type="text" class="form-control" name="txtEditarLocalidad" required>
            <input type="hidden" name="idLocalidad">
            <input type="hidden" name="funcion" value="editarLocalidad">
          </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer ">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">Editar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>