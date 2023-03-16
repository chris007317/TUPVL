<?php 
  $datosTipoLocalidad = ControladorLocalidad::ctrMostrarLocalidadesActivas($_SESSION['idMunicipalidadPvl']);  
  $cantidadLocalidades = count($datosTipoLocalidad);
  $cantidadComites = ControladorComite::ctrContarComite($_SESSION['idMunicipalidadPvl']);
 ?>
<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-10">
          <h1 >Comités</h1>
          <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box bg-gradient-warning">
                <span class="info-box-icon bg-danger"><i class="fas fa-map-marker-alt"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Localidades activas</span>
                  <span class="info-box-number"><?php echo number_format($cantidadLocalidades); ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box bg-gradient-warning">
                <span class="info-box-icon bg-secondary"><i class="fas fa-house-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total comités</span>
                  <span class="info-box-number"><?php echo number_format($cantidadComites['total']); ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box bg-gradient-warning">
                <span class="info-box-icon bg-info"><i class="fas fa-clipboard-check"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Comités activos</span>
                  <span class="info-box-number" id="comitesActivos"></span>
                  <div class="progress">
                    <div class="progress-bar" id="porcentajeComites"></div>
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
            <li class="breadcrumb-item active">Entradas</li>
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
            <div class="card-header">
              <div class="form-group d-sm-flex">
                <button class="btn btn-info m-1" data-toggle="modal" data-target="#agregarComite" id="btnAgregarComite"><i class="fas fa-plus"></i> Agregar comité</button>
                <div class="m-1 w-50">
                  <select class="form-control select2" id="cmbComiteLocalidad" style="width: 100%;" required>
                    <option value="">Seleccione localidad</option>
                    <option value="0">Ver todos los Comités</option>
                    <?php foreach ($datosTipoLocalidad as $key => $value): ?>
                      <option value="<?php echo $value['idLocalidad']; ?>"><?php echo $value['nombreLocalidad']; ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive" id="tablaComites" width="100%">
                <thead>
                  <tr>
                    <th style="width: 15px;">#</th>
                    <th>Localidad</th>
                    <th>Comité</th>
                    <th>Dirección</th>
                    <th>Descripción</th>
                    <th>Presidenta</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
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

<div class="modal" id="agregarComite">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formAgregarComite">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <input type="hidden" name="funcion">
          <input type="hidden" name="idComite">
          <div class="form-group mb-3">
            <select class="form-control select2" name="cmbLocalidadComite" id="cmbLocalidadComite" style="width: 100%;" required>
              <?php foreach ($datosTipoLocalidad as $key => $value): ?>
                <option value="<?php echo $value['idLocalidad']; ?>"><?php echo $value['nombreLocalidad']; ?></option>
              <?php endforeach ?>
            </select>
          </div>  
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
            <span class="fas fa-house-user"></span>
            </div>
            <input type="text" class="form-control" name="txtNombreComite" placeholder="Nombre del comité" required> 
          </div>  
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-map-marker-alt"></span>
            </div>
            <input type="text" class="form-control" name="txtDireccionComite" placeholder="Dirección" required> 
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-sort-numeric-up"></span>
            </div>
            <input type="text" class="form-control" name="txtNumeroComite" placeholder="Número de dirección" min="0" required> 

          </div>
          <div class="form-group">
            <p>Escriba una descripción acerca del comité:</p>
            <textarea class="form-control" rows="4" placeholder="descripción..." name="txtDescripcionComite"></textarea>
          </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">Agregar</button>
          </div>
        </div>
        <?php
        if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'agregar') {
          $registrarComite = new ControladorComite();
          $registrarComite->ctrAgregarComite();
        }else if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editar') {
          $registrarComite = new ControladorComite();
          $registrarComite->ctrEditarComite();
        }
        ?>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="agregarPresidente">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formAgregarPresidente">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="d-inline-flex w-75 pr-2">
              <div class="input-group-append input-group-text">
                <span class="fas fa-address-card"></span>
              </div>
              <input type="text" class="form-control" name="txtDniPresidente" placeholder="Número de DNI" maxlength="8" minlength="8" pattern="[0-9]+" required autofocus> 
            </div>
            <button type="button" class="btn btn-info w-25" id="btnBuscarPresidente">Buscar</button>
          </div>
          <div class="alert text-center alert-danger" id="alertaDniPresi" style="display: none;">
            <span></span>
          </div>
          <div class="alert text-center alert-info" id="alertaDniPresi1" style="display: none;">
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
            <input type="text" class="form-control" name="txtNombrePresidente" placeholder="Nombres" readonly required>
          </div>
          <hr class="">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-calendar-day"></span>
            </div>
            <input type="date" class="form-control" name="dateFechaPresidente" max="<?php echo date('Y-m-d'); ?>" required> 
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-at"></span>
            </div>
            <input type="email" class="form-control" name="txtCorreoPresidente" placeholder="Correo Presidente"> 
          </div>
          <div class="input-group">
            <div class="input-group-append input-group-text">
              <span class="fas fa-mobile-alt"></span>
            </div>
            <input type="text" class="form-control" name="txtCelularPresidente" minlength="9" maxlength="9" placeholder="Número de celular"> 
          </div>
        </div>
        <input type="hidden" name="idPresidente">
        <input type="hidden" name="idComite">
        <input type="hidden" name="funcionPresidente">
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">Agregar</button>
          </div>
        </div>
        <?php
        if (isset($_POST['funcionPresidente']) && !empty($_POST['funcionPresidente']) && $_POST['funcionPresidente'] == 'agregar') {
          $registrarPresidente = new ControladorPresidente();
          $registrarPresidente->ctrAgregarPresidente();
        }else if (isset($_POST['funcionPresidente']) && !empty($_POST['funcionPresidente']) && $_POST['funcionPresidente'] == 'editar') {
          $editarPresidente = new ControladorPresidente();
          $editarPresidente->ctrEditarPresidente();
        }else if (isset($_POST['funcionPresidente']) && !empty($_POST['funcionPresidente']) && $_POST['funcionPresidente'] == 'cambiar') {
          $cambiarPresidente = new ControladorPresidente();
          $cambiarPresidente->ctrCambiarPresidente();
        }
        ?>
      </form>
    </div>
  </div>
</div>