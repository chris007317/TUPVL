<?php 
  $propuestas = ControladorPropuesta::ctrMostrarPropuestas();
 ?>
<div class="content-wrapper" style="min-height: 1419.6px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Municipalidades propuestas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Propuestas</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card card-danger card-outline">
      <div class="card-header">
        <div class="input-group col-5">
          <input class="form-control" name="txtBuscarPropuesta" type="text" placeholder="Buscar producto">
          <div class="input-group-append ">
            <button class="btn btn-default"><i class="fas fa-search"></i></button>
          </div>
        </div>
      </div>
      <div class="card-body pb-0">
        <div class="row d-flex align-items-stretch" id="cuerpoPropuestas">
          <?php foreach ($propuestas as $key => $value): ?>
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
              <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                  RUC: <?php echo $value['ruc']; ?> 
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?php echo $value['nombreMunicipalidad']; ?></b></h2>
                      <p class="text-muted text-sm"><b>Dirección: </b> <?php echo $value['direccion'] ?> </p>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <?php 
                          $region = ControladorPropuesta::ctrMostrarRegion($value['idDistrito']);
                         ?>
                        <li class="small"><span class="fa-li"><i class="fas fa-map-marker-alt"></i></span> Región: <?php echo $region['nombreDepartamento'].', '.$region['nombreProvincia'].', '.$region['nombreDistrito']; ?></li>
                        <li class="small"><span class="fa-li"><i class="fas fa-user-tie"></i></span> Responsable: <?php echo $value['apellidoPaterno'].' '.$value['apellidoMaterno'].', '.$value['nombres']; ?></li>
                      </ul>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?php echo $ruta; ?>/sistema/vistas/<?php echo $value['imagenMunicipalidad']; ?>" alt="" class="img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <button class="btn btn-sm btn-outline-danger mt-1 accion" funcion="rechazarPropuesta" title="Rechazar" idPropuesta="<?php echo $value['idPropuestas']; ?>">
                      <i class="fas fa-minus-square"></i> Rechazar
                    </button>
                    <button class="btn btn-sm btn-outline-success mt-1 accion" funcion="aceptarPropuesta" title="Aceptar" idPropuesta="<?php echo $value['idPropuestas']; ?>">
                      <i class="fas fa-check-square"></i> Aceptar
                    </button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>