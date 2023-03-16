<?php 
  $tipoBeneficiarioDatos = ControladorTipoBeneficiario::ctrMostrarTipoBeneficiario();
 ?>

<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header"> 
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Tipo de benificiarios</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Tipo de benificiarios</li>
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
          <div class="card card-danger ">
            <div class="card-header">
            <!-- 
                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#agregarTipoBeneficiario">
                  <i class="fas fa-plus"></i> Agregar tipo beneficiario
                </button>
             -->
            </div>
            <div class="card-body">
              <table class="table table-sm">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Tipo de beneficiario</th>
                      <th>Descripción</th>
                      <th style="width: 100px">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($tipoBeneficiarioDatos as $key => $value): ?>
                      <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $value['nombreTipoBeneficiario']; ?></td>
                        <td>
                          <?php echo $value['descripcion']; ?>
                        </td>
                        <td>
                            <button class='btn btn-warning btn-sm editarTipoBeneficiario'  data-toggle='modal' data-target='#editarTipoBeneficiario' idTipoBeneficiario=<?php echo $value['idTipoBeneficiario'] ?>>
                              <i class='fas fa-pencil-alt'></i>
                            </button>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>

<!-- Crear nuevo banner -->
<div class="modal" id="agregarTipoBeneficiario">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Agregar tipo de beneficiario</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-list-ul"></span>
            </div>
            <input type="text" class="form-control" name="txtTipoBeneficiario" placeholder="Ingresa nombre" required> 
          </div>
          <div class="form-group">
              <p>Escriba la descripción:</p>
              <textarea class="form-control" rows="4" placeholder="descripción" name="txtDescripcionTipoBenef"></textarea>
            </div>
          </div>
        <!-- Modal footer -->
        <div class="modal-footer ">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </div>
        <?php
          $registrarRequisito = new ControladorTipoBeneficiario();
          $registrarRequisito->ctrRegistrarTipoBeneficiario();
        ?>
      </form>
    </div>
  </div>
</div>

<!-- Crear nuevo banner -->
<div class="modal" id="editarTipoBeneficiario">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Editar tipo de beneficiario</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-list-ul"></span>
            </div>
            <input type="text" class="form-control" name="txtEditarTipoBeneficiario" disabled> 
          </div>
          <div class="form-group">
              <p>Escriba la descripción:</p>
              <textarea class="form-control" rows="4" placeholder="descripción" name="txtEditarDescripcionTipoBenef"></textarea>
            </div>
          </div>
          <input type="hidden" name="idTipoBeneficiario">
        <!-- Modal footer -->
        <div class="modal-footer ">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">editar</button>
          </div>
        </div>
        <?php
          $registrarRequisito = new ControladorTipoBeneficiario();
          $registrarRequisito->ctrEditarTipoBeneficiario();
        ?>
      </form>
    </div>
  </div>
</div>

