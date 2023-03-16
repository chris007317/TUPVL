<?php 
  $datosProductos = ControladorProducto::ctrMostrarListaProductos($_SESSION['idMunicipalidadPvl']);
  $datosProveedor = ControladorProveedor::ctrMostrarProveedoresActivos($_SESSION['idMunicipalidadPvl']);
  date_default_timezone_set('America/Lima');
 ?>
<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Recepción de productos</h1>
        </div>
        <div class="col-sm-6">
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
              <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#agregarEntrada" id="btnNuevaEntrada">
                <i class="fas fa-plus"></i> Nueva Recepción
              </button>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive" id="tablaEntradas" width="100%">
                <thead>
                  <tr>
                    <th style="width: 15px;">#</th>
                    <th>Nombre - Marca</th>
                    <th>Proveedor</th>
                    <th>RUC</th>
                    <th>Observación</th>
                    <th>Recibido</th>
                    <th>Cantidad</th>
                    <th>Usuario</th>
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

<div class="modal" id="agregarEntrada">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formAgregarEntrada">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Agregar proveedor</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group mb-3">
            <select class="form-control select2" name="cmbEntradaProductos" id="cmbEntradaProductos" style="width: 100%;" required>
              <?php foreach ($datosProductos as $key => $value): ?>
                <option value="<?php echo $value['idProducto']; ?>"><?php echo $value['nombreProducto'].' - '.$value['marcaProducto']; ?></option>
              <?php endforeach ?>
            </select>
          </div>  
          <div class="form-group mb-3">
            <select class="form-control select2" style="width: 100%;" name="cmbEntradaProveedores" id="cmbEntradaProveedores" required>
              <?php foreach ($datosProveedor as $key => $value): ?>
                <option value="<?php echo $value['idProveedor']; ?>"><?php echo $value['nombreProveedor']; ?></option>
              <?php endforeach ?>
            </select>
          </div>  
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-calendar-day"></span>
            </div>
            <input type="date" class="form-control" name="dateEntradaProducto" max="<?php echo date('Y-m-d') ?>" required> 
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-sort-numeric-up"></span>
            </div>
            <input type="number" min="1" pattern="^[0-9]+" class="form-control" name="txtCantidadEntrada" placeholder="Cantidad" required> 
          </div>
          <hr class="">
          <div class="form-group">
            <p>Escriba si existe una observación:</p>
            <textarea class="form-control" rows="4" placeholder="descripción" name="txtObservacionEntrada"></textarea>
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
          $nuevaEntrada = new ControladorEntrada();
          $nuevaEntrada->ctrNuevaEntrada();
        ?>
      </form>
    </div>
  </div>
</div>