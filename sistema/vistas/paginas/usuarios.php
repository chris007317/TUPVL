<?php 
  $tipoUsuario = ControladorUsuario::ctrMostrarTipoUsuario();
 ?>
<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Usuarios</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Usuarios</li>
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
              <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#agregarUsuario" id="btnAgregarUsuario">
                <i class="fas fa-plus"></i> Agregar usuario
              </button>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive" id="tablaUsuarios" width="100%">
                <thead>
                  <tr>
                    <th style="width: 15px;">#</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Nombres y apellidos</th>
                    <th>Celular</th>
                    <th>Perfil</th>
                    <th>Imagen</th>
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


<!-- Scrollable modal -->
<div class="modal" id="agregarUsuario">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formAgregarUsuario" enctype="multipart/form-data">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Agregar usuario</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="d-inline-flex w-75 pr-2">
              <div class="input-group-append input-group-text">
                <span class="fas fa-address-card"></span>
              </div>
              <input type="text" class="form-control" name="txtDniUsuario" placeholder="Número de DNI" maxlength="8" minlength="8" pattern="[0-9]+" required autofocus> 
            </div>
            <button type="button" class="btn btn-info w-25" id="btnBuscarUsurio">Buscar</button>
          </div>
          <div class="alert text-center alert-danger" id="alertaDniUsuario" style="display: none;">
            <span></span>
          </div>
          <div class="alert text-center alert-info" id="alertaDniUsuario1" style="display: none;">
            <span></span>
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
            <input type="text" class="form-control" name="txtNombreUsuario" placeholder="Nombres" readonly required>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-at"></span>
            </div>
            <input type="email" class="form-control" name="txtCorreoUsuario" placeholder="Correo"> 
          </div>
          <div class="input-group">
            <div class="input-group-append input-group-text">
              <span class="fas fa-mobile-alt"></span>
            </div>
            <input type="text" class="form-control" name="txtCelularUsuario" minlength="9" maxlength="9" pattern="[0-9]+" placeholder="Número de celular"> 
          </div>
          <hr>
          <div class="form-group">
            <div class="form-group my-2">
              <div class="btn btn-default btn-file">
                  <i class="fas fa-paperclip"></i> Adjuntar Imagen de perfil
                  <input type="file" name="flImgUsuario">
              </div>
              <img class="img-fluid py-2" id="imgVerUsuario">
               <p class="help-block small">Dimensiones: 359px * 254px | Peso Max. 2MB | Formato: JPG o PNG</p>
            </div>
          </div>
          <hr class="">
          <div class="form-group mb-3">
            <select class="form-control select2" name="cmbPerfil" id="cmbPerfil" style="width: 100%;"  required>
              <option value="">Seleccione tipo de usuario</option>
              <?php foreach ($tipoUsuario as $key => $value): ?>
                <option value="<?php echo $value['idTipoUsuario']; ?>"><?php echo $value['nombreTipoUsuario']; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-user-lock"></span>
            </div>
            <input type="text" class="form-control" name="txtUsuario" placeholder="Nombre de usuario" required> 
          </div>
           <div class="input-group ">
            <div class="input-group-append input-group-text">
              <span class="fas fa-lock"></span>
            </div>
            <input type="password" class="form-control" name="txtContraUsuario" placeholder="Contraseña" required> 
          </div>
        </div>
        <input type="hidden" name="idPersona" value="">
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
        $agregarUsuario = new ControladorUsuario();
        $agregarUsuario->ctrAgregarUsuario();
        ?>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="editarUsuario">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formEditarUsuario">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title" id="titulo"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-at"></span>
            </div>
            <input type="email" class="form-control" name="txtEditarCorreo" placeholder="Correo"> 
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-mobile-alt"></span>
            </div>
            <input type="text" class="form-control" name="txtEditarCeluar" minlength="9" maxlength="9" pattern="[0-9]+" placeholder="Número de celular"> 
          </div>
          <div class="form-group mb-3">
            <select class="form-control" name="cmbEditarPerfil" id="cmbEditarPerfil" style="width: 100%;"  required>
              <?php foreach ($tipoUsuario as $key => $value): ?>
                <option value="<?php echo $value['idTipoUsuario']; ?>"><?php echo $value['nombreTipoUsuario']; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-user-lock"></span>
            </div>
            <input type="text" class="form-control" name="txtEditarUsuario" placeholder="Nombre de usuario" required> 
          </div>
        </div>
        <input type="hidden" name="idUsuario">
        <input type="hidden" name="funcion" value="editarUsuario">
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

<!-- Scrollable modal -->
<div class="modal" id="editarImg">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formEditarImg" enctype="multipart/form-data">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title" id="tituloImg"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="form-group my-2">
              <div class="btn btn-default btn-file">
                  <i class="fas fa-paperclip"></i> Adjuntar Imagen de perfil
                  <input type="file" name="flEditarImg" id="flEditarImg">
              </div>
              <img class="img-fluid py-2" id="imgEditar">
               <p class="help-block small">Dimensiones: 359px * 254px | Peso Max. 2MB | Formato: JPG o PNG</p>
            </div>
          </div>
          
        </div>
        <input type="hidden" name="idPersonaImg" value="">
        <input type="hidden" name="funcion" value="editarImg">
        <input type="hidden" name="imgActual">
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary" id="btnEditar" disabled>Editar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scrollable modal -->
<div class="modal" id="cambiarContra">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formContra">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Cambiar contraseña</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group pb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-lock"></span>
            </div>
            <input type="password" class="form-control" name="txtContraUsuario1" placeholder="Nueva Contraseña" required> 
          </div>
          <div class="input-group ">
            <div class="input-group-append input-group-text">
              <span class="fas fa-lock"></span>
            </div>
            <input type="password" class="form-control" name="txtContraUsuario2" placeholder="Confirmar Contraseña" required> 
          </div>
        </div>
        <input type="hidden" name="idUsuarioContra" value="">
        <input type="hidden" name="funcion" value="editarContra">
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>