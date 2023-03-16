<?php
  $datosDepartamentos = ControladorDireccion::ctrMostrarDepartamentos();
  $datosTipoLocalidad = ControladorLocalidad::ctrMostrarLocalidadesActivas($_SESSION['idMunicipalidadPvl']);  
  $cantidadComites = ControladorComite::ctrContarComite($_SESSION['idMunicipalidadPvl']);
  $cantidadPresidentes = ControladorPresidente::ctrContarPresidentes($_SESSION['idMunicipalidadPvl']);
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
                <span class="info-box-icon bg-danger"><i class="fas fa-house-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Comités</span>
                  <span class="info-box-number"><?php echo number_format($cantidadComites['total']); ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box bg-gradient-warning">
                <span class="info-box-icon bg-secondary"><i class="fas fa-user-tie"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total presindetes</span>
                  <span class="info-box-number"><?php echo number_format($cantidadPresidentes['total']); ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box bg-gradient-warning">
                <span class="info-box-icon bg-info"><i class="fas fa-user-check"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Presidentes activos</span>
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
          </div>
        </div>
        <div class="col-sm-2">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Presidentes</li>
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
              <div class="row">
                <div class="mr-1">
                  <select class="form-control select2"  id="cmbLocalidad">
                    <option value="">Seleccione localidad</option>
                    <option value="0">Ver todos las localidades</option>
                    <?php foreach ($datosTipoLocalidad as $key => $value): ?>
                      <option value="<?php echo $value['idLocalidad']; ?>"><?php echo $value['nombreLocalidad']; ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <button class="btn btn-sm btn-warning text-white" id="btnActivos" estado="1">Ver presidentes activos</button>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive" id="tablaPresidentes" width="100%">
                <thead>
                  <tr>
                    <th style="width: 15px;">#</th>
                    <th>Presidente</th>
                    <th>DNI</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Celular</th>
                    <th style="width: 50px;">fecha</th>
                    <th>Localidad</th>
                    <th>Comité</th>
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
            <input type="text" class="form-control" name="txtPresidente" placeholder="Apellidos y nombres" disabled> 
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

<div class="modal" id="modalPresidente">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formPresidente">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Editar presidente</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-address-card"></span>
            </div>
            <input type="text" class="form-control" name="txtDniPresidente" placeholder="Número de DNI" maxlength="8" minlength="8" pattern="[0-9]+" required disabled> 
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <input type="text" class="form-control" name="txtApellidoPaterno" placeholder="Apellido Paterno" disabled>
            </div>
            <div class="form-group col-md-6">
              <input type="text" class="form-control" name="txtApellidoMaterno" placeholder="Apellido Materno" disabled>
            </div>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="txtNombrePresidente" placeholder="Nombres" disabled>
          </div>
          <hr class="">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-calendar-day"></span>
            </div>
            <input type="date" class="form-control" name="dateFechaPresidente" max="<?php echo date('Y-m-d') ?>" required> 
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
        <input type="hidden" name="funcion">
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </div>
        <?php 
        if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarPresidente') {
          $editarPresidente = new ControladorPresidente();
          $editarPresidente->ctrEditarPresidente();
        }
         ?>
      </form>
    </div>
  </div>
</div>