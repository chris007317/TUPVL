<?php 
  $requisitosDatos = ControladorRequisitos::ctrMostrarRequisitos();
 ?>

<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Requisitos</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Requisitos</li>
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
              <button class="btn btn-info btn-sm" id="btnAgregarRequisito" data-toggle="modal" data-target="#agregarRequisito">
                <i class="fas fa-plus"></i> Agregar requisito
              </button>
            </div>
            <div class="card-body">
              <table class="table table-sm">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Requisitos</th>
                      <th>Descripción</th>
                      <th style="width: 100px">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($requisitosDatos as $key => $value): ?>
                      <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $value['nombreRequisito']; ?></td>
                        <td>
                          <?php echo $value['descripcionRequisito']; ?>
                        </td>
                        <td>
                            <button class='btn btn-warning btn-sm editarRequisito'  data-toggle='modal' data-target='#editarRequisito' idRequisito=<?php echo $value['idRequisito'] ?>>
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
<div class="modal" id="agregarRequisito">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formAgregarRequisito">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Agregar requisito</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-list-ul"></span>
            </div>
            <input type="text" class="form-control" name="txtRequsito" placeholder="Ingresa nombre del requisito" required> 
          </div>
          <div class="form-group">
            <p>Escriba la descripción del requisito:</p>
            <textarea class="form-control" rows="4" placeholder="descripción" name="txtDescripcionRequisito"></textarea>
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
          $registrarRequisito = new ControladorRequisitos();
          $registrarRequisito->ctrRegistrarRequisitos();
        ?>
      </form>
    </div>
  </div>
</div>

<!-- Crear nuevo banner -->
<div class="modal" id="editarRequisito">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Editar requisito</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-list-ul"></span>
            </div>
            <input type="text" class="form-control" name="txtEditarRequsito" placeholder="Ingresa nombre del requisito" disabled> 
          </div>
          <div class="form-group">
              <p>Escriba la descripción del requisito:</p>
              <textarea class="form-control" rows="4" placeholder="descripción" name="txtEditarDescripcionReq"></textarea>
            </div>
          </div>
          <input type="hidden" name="idRequisitos">
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
          $registrarRequisito = new ControladorRequisitos();
          $registrarRequisito->ctrEditarRequisito();
        ?>
      </form>
    </div>
  </div>
</div>

