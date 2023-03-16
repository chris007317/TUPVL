<?php
  $idMunicipalidadPeriodo = $_SESSION['idMunicipalidadPvl'];
  $periodo = ControladorMunicipalidad::ctrMostrarPeriodoMunicipalidad($idMunicipalidadPeriodo);
  $periodoMeses = ControladorMunicipalidad::ctrMostrarPeriodos($idMunicipalidadPeriodo, "leche");
  
  $disponibles = ControladorAlmacen::VerProductos($idMunicipalidadPeriodo);
  $checkPeriodo = mesesPeriodo($periodoMeses);

  //$totalBeneficiarios = ControladorBeneficiario::ctrTotalBeneficiarios($idMunicipalidadPeriodo, 1);

 ?>
<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Programar entregas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Programar entregas</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
<section class="content">
      <div class="row">
        <div class="col-md-3 col-sm-4 ">
          <div class="card card-info">
            <div class="card-header bg-secondary">
              <h3 class="card-title">Productos por periodo</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body" style="display: block;">
              <form id="formProgramarPeriodo">
                <div class="form-group">
                  <label>Producto a distribuir</label>
                  <select class="form-control custom-select" id="cmbPeriodoProducto" name="cmbPeriodoProducto">
                    <option value="">Seleccione una opción</option>
                    <?php foreach ($disponibles as $key => $value): ?>
                      <option value="<?php echo $value['nombreProducto']; ?>"><?php echo $value['nombreProducto']; ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-inline">
                  <p class="w-100"><strong>Productos disponibles </strong><span id="productosDisponibles" class="float-right badge badge-info">0</span></p>
                </div>
                <div class="form-group">
                  <label>Año</label>
                  <input type="number" class="form-control" name="yearPerido" value="<?php echo date("Y"); ?>" readonly required>
                </div>
                <div class="form-group">
                  <label >Seleccion meses de dsitribución</label>
                  <div class="ml-4" id="mesesPeriodo">
                  </div>
                </div>
                <div class="form-inline text-center">
                  <p class="w-100"><span id="validar" class="badge badge-info"></span></p>
                </div>
                <input type="hidden" name="totalBeneficiarios">
                <input type="hidden" name="totalProductos">
                <input type="hidden" name="funcion" value="programarEntrega">
                <div class="text-center">
                  <button type="submit" class="btn btn-azul btn-block">Calcular</button>
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6 col-sm-8 ">
          <div class="card">
            <div class="card-header bg-secondary">
              <h3 class="card-title">Global de productos a entregar</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body p-0" style="display: block;">
              <div class="table-responsive p-0">
                <table class="table table-striped" >
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Mes</th>
                      <th>Beneficiarios</th>
                      <th>Ración</th>
                      <th>Cantidad</th>
                      <th>Sobrante</th>
                    </tr>
                  </thead>
                  <tbody id="tableProgramaProductos">
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <div class="card ">
            <div class="card-header bg-secondary">
              <h3 class="card-title">Productos a entregar</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body p-0" style="display: block;">
              <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Alimento</th>
                    <th>Marca</th>
                    <th>Mes</th>
                    <th>Cantidad</th>
                    <th>Año</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody id="tableProductosEntregar">
                </tbody>
              </table>
            </div>
            </div>
            <!-- /.card-body -->
          </div>

        </div>
        <div class="col-md-3 flex-wrap">
          <div class="row ">
            <div class="col-md-12 col-sm-4 col-4">
              <!-- small box -->
              <div class="small-box bg-info d-sm-flex flex-wrap">
                <div class="inner col-12 col-md-6 col-lg-8">
                  <h3 id="totalBenef">0</h3>
                  <p>Beneficiarios activos 1er mes</p>
                </div>
                <div class="icon col-0 col-md-4 col-lg-4">
                  <span  style="font-size: 60px;"><i class="fas fa-users"></i></span>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-sm-4 col-4">
              <!-- small box -->
              <div class="small-box bg-info d-sm-flex flex-wrap">
                <div class="inner col-12 col-md-6 col-lg-8">
                  <h3 id="productosTotal">0</h3>
                  <p>Productos disponibles</p>
                </div>
                <div class="icon col-0 col-md-4 col-lg-4">
                  <span  style="font-size: 60px;"><i class="fas fa-users"></i></span>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-sm-4 col-4">
              <!-- small box -->
              <div class="small-box bg-info d-sm-flex flex-wrap" id="prodRepartir">
                <div class="inner col-12 col-md-6 col-lg-8">
                  <h3 id="productosPeriodo">0</h3>
                  <p>Ración del 1er mes</p>
                </div>
                <div class="icon col-0 col-md-4 col-lg-4">
                  <span  style="font-size: 60px;"><i class="fas fa-users"></i></span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group ">
            <div class="w-100 text-center">
              <button class="btn btn-azul col-md-12 col-sm-6" id="btnGuardarPrograma">Guardar programa</button>
            </div>
          </div>
            <!-- small box -->
        </div>
      </div>
    <p><strong>Importante:</strong> La distribución de los alimentos se calcula de acuerdo a la fecha de registro y la fecha de vencimiento.
      <!--  (Fecha registro <= Fecha entrega y Fecha vencimiento > = Fecha entrega) -->    
    </p>
     
    </section>
  <!-- /.content -->
</div>