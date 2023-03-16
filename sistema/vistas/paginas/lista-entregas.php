<?php 
  $disponibles = ControladorAlmacen::VerProductos($_SESSION['idMunicipalidadPvl']);
  $yearLista = ControladorMunicipalidad::ctrMostrarPeriodosYear($_SESSION['idMunicipalidadPvl']);
  $year = date('Y');
 ?>
<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Lista de entregas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">lista entregas</li>
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
                  <select class="form-control select2" name="cmbYear" id="cmbYear">
                    <?php foreach ($yearLista as $key => $value): ?>
                      <?php if ($value['yearEntrega'] == $year): ?>
                        <option value="<?php echo $value['yearEntrega']; ?>" selected><?php echo $value['yearEntrega']; ?></option>
                      <?php else: ?>
                        <option value="<?php echo $value['yearEntrega']; ?>"><?php echo $value['yearEntrega']; ?></option>
                      <?php endif ?>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group mr-1">
                  <select class="form-control select2" id="cmbNombreProducto" name="cmbNombreProducto">
                    <option value="">Seleccione una opción</option>
                    <?php foreach ($disponibles as $key => $value): ?>
                      <option value="<?php echo $value['nombreProducto']; ?>"><?php echo $value['nombreProducto']; ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group mr1" >
                  <button class="btn btn-jade" id="btnVerProducto"><i class="fas fa-eye"></i> Ver</button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive" id="tablePrograma" width="100%">
                <thead>
                  <tr>
                    <th style="width: 15px;">#</th>
                    <th>Codigó</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Mes</th>
                    <th>Entregados</th>
                    <th>Estado</th>
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