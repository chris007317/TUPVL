<?php 
  $totalBeneficiarios = $datosBenef->ctrTotalBeneficiarios($_SESSION['idMunicipalidadPvl'], 1);
  $totalSocios = ControladorSocio::ctrTotalSocios($_SESSION['idMunicipalidadPvl'], 1);
  $totalComites = ControladorComite::ctrTotalComites($_SESSION['idMunicipalidadPvl'], 1);
 ?>
<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header pb-0">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Analíticas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Analíticas</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info d-sm-flex flex-wrap">
              <div class="inner col-12 col-md-6 col-lg-8">
                <h3><?php echo $totalBeneficiarios['total']; ?></h3>
                <p>Benficiarios</p>
              </div>
              <div class="icon col-0 col-md-4 col-lg-4">
                <span  style="font-size: 60px;"><i class="fas fa-child"></i></span>
              </div>
              <div class="w-100 text-center small-box-footer">
                <a href="nuevo-beneficiario" class="text-white">Nuevo beneficiario <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info d-sm-flex flex-wrap">
              <div class="inner col-12 col-md-6 col-lg-8">
                <h3><?php echo $totalSocios['total']; ?></h3>
                <p>Socios</p>
              </div>
              <div class="icon col-0 col-md-4 col-lg-4">
                <span  style="font-size: 60px;"><i class="fas fa-user-friends"></i></span>
              </div>
              <div class="w-100 text-center small-box-footer">
                <a href="socios" class="text-white">Ver socios <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info d-sm-flex flex-wrap">
              <div class="inner col-12 col-md-6 col-lg-8">
                <h3><?php echo $totalComites['total']; ?></h3>
                <p>Comités</p>
              </div>
              <div class="icon col-0 col-md-4 col-lg-4">
                <span  style="font-size: 60px;"><i class="fas fa-house-user"></i></span>
              </div>
              <div class="w-100 text-center small-box-footer">
                <?php if ($datosUsuario['idTipoUsuario'] != 4): ?>
                <a href="comites" class="text-white">Ver comités <i class="fas fa-arrow-circle-right"></i></a>  
                <?php else: ?>
                <a href="#" class="text-white">Total</a>
                <?php endif ?>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info d-sm-flex flex-wrap">
              <div class="inner col-12 col-md-6 col-lg-8">
                <h3><?php echo $totalPostulante['total']; ?></h3>
                <p>Postulantes</p>
              </div>
              <div class="icon col-0 col-md-4 col-lg-4">
                <span  style="font-size: 60px;"><i class="fas fa-users"></i></span>
              </div>
              <div class="w-100 text-center small-box-footer">
                <a href="nuevo-postulante" class="text-white">Registrar postulante <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Grafica de Beneficiarios</h3>
                  <a href="javascript:void(0);">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg" id="totalBenef"></span>
                    <span>Beneficiaros activos</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 12.5%
                    </span>
                    <span class="text-muted">Since last week</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                  <canvas id="graficoPiet" height="400" width="1674" class="chartjs-render-monitor" style="display: block; height: 275px; width: 837px;"></canvas>
                </div>


              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between ">
                  <h3 class="card-title">Salida de productos</h3>
                  <a href="entregados">Ver salidas</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg" id="TotalProd"></span>
                    <span>Productos entregados en los ultimos meses</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                    <span class="text-muted">Since last month</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                  <canvas id="graficoBarras" height="400" style="display: block; height: 250px; width: 837px;" width="1674" class="chartjs-render-monitor"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Leche
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Avena
                  </span>
                </div>
              </div>
            </div>
            
          </div>
          <!-- /.col-md-6 -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
  <!-- /.content -->
</div>