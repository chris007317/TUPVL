<?php
  $datosDepartamentos = ControladorDireccion::ctrMostrarDepartamentos();
?>
<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
         <div class="col-sm-10">
          <h1 >Socios</h1>
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
                <button class="btn btn-sm btn-warning text-white" id="btnActivos" estado="1">Ver socios activos</button>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive" id="tablaSocios" width="100%">
                <thead>
                  <tr>
                    <th style="width: 25px;">#</th>
                    <th>Socio</th>
                    <th>DNI</th>
                    <th>Dirección</th>
                    <th>Descripción</th>
                    <th>Correo</th>
                    <th>Celular</th>
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

<div class="modal" id="modalSocio">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formSocio">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Editar Socio</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-address-card"></span>
            </div>
            <input type="text" class="form-control" name="txtDniSocio" placeholder="Número de DNI" maxlength="8" minlength="8" pattern="[0-9]+" required readonly> 
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
        <input type="hidden" name="idSocio" >
        <input type="hidden" name="funcion" required>
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

<div class="modal" id="modalBeneficiarios">
  <div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header bg-info">
          <h4 class="modal-title">Beneficiarios activos registrados</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="card m-0" >
            <ul class="list-group list-group-flush" id="verBeneficiarios">
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