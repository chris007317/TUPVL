<?php 
  $disponibles = ControladorAlmacen::VerProductos($_SESSION['idMunicipalidadPvl']);
  $nombreMeses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $yearLista = ControladorMunicipalidad::ctrMostrarPeriodosYear($_SESSION['idMunicipalidadPvl']);
  $year = date('Y');
 ?>
<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Entregar Producto</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Entregar productos</li>
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
                  <select class="form-control select2" id="cmNombreMes" name="cmNombreMes">
                    <option value="">Seleccione una opción</option>
                    <?php foreach ($nombreMeses as $key => $value): ?>
                      <option value="<?php echo $key+1; ?>"><?php echo $value; ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group mr1" >
                  <button class="btn btn-jade" id="btnVerEntrega"><i class="fas fa-eye"></i> Ver</button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive" id="tablaEntregarProductos" width="100%">
                <thead>
                  <tr>
                    <th style="width: 15px;">#</th>
                    <th>Localidad</th>
                    <th>Comité</th>
                    <th style="width: 40px;">Beneficiarios</th>
                    <th style="width: 30px;">Avena</th>
                    <th style="width: 30px;">Leche</th>
                    <th style="width: 30px;">Total</th>
                    <th style="width: 140px;">Entregar</th>
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

<div class="modal" id="entregarAlimento">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formEntregarALimento">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Entregar alimentos</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="card">
            <ul class="list-group list-group-flush" id="listaPost">
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Comité: </strong></div>
                <div class="w-60"><span id="nombreComite"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Beneficiarios:</strong></div>
                <div class="w-60"><span class="badge badge-warning" id="cantBenef"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Alimento:</strong></div>
                <div class="w-60"><span class="badge badge-info" id="nombreAlimento"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="w-40"><strong>Cantidad:</strong></div>
                <div class="w-60"><span class="badge badge-info" id="cantAlimento"></span></div>
              </li>
              <li class="list-group-item d-sm-flex">
                <div class="row w-100" id="listaAlimento"></div>
              </li>
            </ul>
          </div>
          <div class="form-group">
            <label>Fecha de entrega:</label>
            <input type="datetime-local" class="form-control" name="dateFechaAlimento" required>
          </div>
          <input type="hidden" name="idComite" required>
          <input type="hidden" name="idMes" required>
          <input type="hidden" name="yearEntrega" required>
          <input type="hidden" name="cantidadEntrega" required>
          <input type="hidden" name="funcion" value="registrarEntrega">
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" id="btnAprobarPost" class="btn btn-primary">Entregar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
