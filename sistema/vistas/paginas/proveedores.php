<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Proveedores</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Proveedores</li>
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
              <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#agregarProveedor" id="btnAgregarProveedor">
                <i class="fas fa-plus"></i> Agregar proveedor
              </button>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive" id="tablaProveedores" width="100%">
                <thead>
                  <tr>
                    <th style="width: 15px;">#</th>
                    <th>Proveedor</th>
                    <th>Ruc</th>
                    <th>Dirección</th>
                    <th>Representante</th>
                    <th>Celular</th>
                    <th>Correo</th>
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

<div class="modal" id="agregarProveedor">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formAgregarProveedor">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Agregar proveedor</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="d-inline-flex w-75 pr-2">
              <div class="input-group-append input-group-text">
                <span class="fas fa-glass-whiskey"></span>
              </div>
              <input type="text" class="form-control" name="txtRucProveedor" placeholder="Número de RUC" maxlength="11" minlength="11" required autofocus> 
            </div>
            <button type="button" class="btn btn-info w-25" id="btnBuscarProveedor">Buscar</button>
          </div>
          <div class="alert text-center alert-danger" id="alertaRuc" style="display: none;">
            <span></span>
          </div>
          <div class="alert text-center alert-info" id="alertaRuc1" style="display: none;">
            <span></span>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
            <span class="fas fa-store"></span>
            </div>
            <input type="text" class="form-control" name="txtNombreProveedor" placeholder="Nombre del proveedor" disabled required> 
          </div>  
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-map-marker-alt"></span>
            </div>
            <input type="text" class="form-control" name="txtDireccionProveedor" placeholder="Dirección fiscal" disabled required> 
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-address-card"></span>
            </div>
            <input type="text" class="form-control" name="txtRepresentanteProveedor" placeholder="Nombre del representante" required> 
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-at"></span>
            </div>
            <input type="email" class="form-control" name="txtCorreoProveedor" placeholder="Correo del proveedor"> 
          </div>
          <div class="input-group">
            <div class="input-group-append input-group-text">
              <span class="fas fa-mobile-alt"></span>
            </div>
            <input type="text" class="form-control" name="txtCelularProveedor" placeholder="Celular del proveedor" minlength="9" maxlength="9"> 
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
          $registrarProveedor = new ControladorProveedor();
          $registrarProveedor->ctrAgregarProveedor();
        ?>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="editarProveedor">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formEditarProveedor">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Editar proveedor</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-glass-whiskey"></span>
            </div>
            <input type="text" class="form-control" name="txtEditarRucProveedor" maxlength="11" minlength="11" disabled> 
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-store"></span>
            </div>
            <input type="text" class="form-control" name="txtEditarNombreProveedor" disabled> 
          </div>  
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-map-marker-alt"></span>
            </div>
            <input type="text" class="form-control" name="txtEditarDireccionProveedor" disabled> 
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-address-card"></span>
            </div>
            <input type="text" class="form-control" name="txtEditarRepresentanteProveedor" placeholder="Nombre del representante" required> 
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-at"></span>
            </div>
            <input type="email" class="form-control" name="txtEditarCorreoProveedor" placeholder="Correo del proveedor"> 
          </div>
          <div class="input-group">
            <div class="input-group-append input-group-text">
              <span class="fas fa-mobile-alt"></span>
            </div>
            <input type="text" class="form-control" name="txtEditarCelularProveedor" placeholder="Celular del proveedor" minlength="9" maxlength="9"> 
          </div>
        </div>
        <input type="hidden" name="idProveedor">
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
          $editarProveedor = new ControladorProveedor();
          $editarProveedor->ctrEditarProveedor();
        ?>
      </form>
    </div>
  </div>
</div>