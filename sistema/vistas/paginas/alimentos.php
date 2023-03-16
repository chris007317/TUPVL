<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="d-sm-flex">
            <h1 class="mr-2">Alimentos</h1>
            <button class="btn btn-info btn-sm" id="btnAgregarProducto" data-toggle="modal" data-target="#agregarAlimento">
                <i class="fas fa-plus"></i> Agregar alimento
            </button>
          </div>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Alimentos</li>
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
              <div class="input-group">
                <input class="form-control " id="txtBuscarUser" type="text" placeholder="Buscar producto">
                <div class="input-group-append">
                  <button class="btn btn-default"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </div>
            <div class="card-body pb-0">
              <div class="row d-flex align-items-stretch" id="cuerpoProductos">
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <nav aria-label="Contacts Page Navigation">
                <ul class="pagination justify-content-center m-0" id="paginador">
                </ul>
              </nav>
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
<div class="modal" id="agregarAlimento">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formAgregarProducto" enctype="multipart/form-data">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Agregar productos</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-glass-whiskey"></span>
            </div>
            <select class="form-control" name="txtNombreProducto">
              <option value="AVENA">AVENA</option>
              <option value="LECHE">LECHE</option>
            </select>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
            <span class="fas fa-store"></span>
            </div>
            <input type="text" class="form-control" name="txtMarcaProducto" placeholder="Marca del producto" required> 
          </div>  
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-barcode"></span>
            </div>
            <input type="text" class="form-control" name="txtCodigoProducto" placeholder="Codigo del producto"> 
          </div>
          <hr class="">
          <div class="form-group">
            <div class="form-group my-2">
              <div class="btn btn-default btn-file">
                  <i class="fas fa-paperclip"></i> Adjuntar Imagen del producto
                  <input type="file" name="flImgProducto">
              </div>
              <img class="img-fluid py-2" id="imgVerProducto">
               <p class="help-block small">Dimensiones: 359px * 254px | Peso Max. 2MB | Formato: JPG o PNG</p>
            </div>
            <p>Escriba la descripción del producto:</p>
            <textarea class="p-3 form-control" rows="4" name="txtDescripcionProducto" maxlength="60"></textarea>
          </div>
          <hr class="">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-weight"></span>
            </div>
            <input type="number" min="0" step="any" class="form-control" name="btxtPesoProducto" placeholder="Peso del producto" required> 
          </div>
           <div class="input-group ">
            <div class="input-group-append input-group-text">
              <span class="fas fa-dollar-sign"></span>
            </div>
            <input type="number" min="0" step="any" class="form-control" name="txtPrecioProducto" placeholder="Precio del producto" required> 
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
        $agregarProducto = new ControladorProducto();
        $agregarProducto->ctrAgregarProducto();
        ?>
      </form>
    </div>
  </div>
</div>
<!-- editar alimento -->
<div class="modal" id="editarAlimento">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formEditarProducto" enctype="multipart/form-data">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Editar productos</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-glass-whiskey"></span>
            </div>
            <select class="form-control" name="txtEditarNombreProducto" id="txtEditarNombreProducto" disabled>
              <option value="AVENA">AVENA</option>
              <option value="LECHE">LECHE</option>
            </select>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
            <span class="fas fa-store"></span>
            </div>
            <input type="text" class="form-control" name="txtEditarMarcaProducto" placeholder="Marca del producto" required> 
          </div>  
          <div class="input-group mb-4">
            <div class="input-group-append input-group-text">
              <span class="fas fa-barcode"></span>
            </div>
            <input type="text" class="form-control" name="txtEditarCodigoProducto" placeholder="Codigo del producto"> 
          </div>
          <hr class="">
          <div class="form-group">
            <div class="form-group my-2">
              <div class="btn btn-default btn-file">
                  <i class="fas fa-paperclip"></i> Adjuntar Imagen del producto
                  <input type="file" name="flEditarImgProducto">
              </div>
              <input type="hidden" name="imgActualProd" >
              <img class="img-fluid py-2" id="imgVerProd">
               <p class="help-block small">Dimensiones: 359px * 254px | Peso Max. 2MB | Formato: JPG o PNG</p>
            </div>
            <p>Escriba la descripción del producto:</p>
            <textarea class="p-3 form-control" rows="4" name="txtEditarDescripcionProducto" maxlength="60"></textarea>
          </div>
          <hr class="">
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <span class="fas fa-weight"></span>
            </div>
            <input type="number" min="0" step="any" class="form-control" name="btxtEditarPesoProducto" placeholder="Peso del producto" required> 
          </div>
           <div class="input-group ">
            <div class="input-group-append input-group-text">
              <span class="fas fa-dollar-sign"></span>
            </div>
            <input type="number" min="0" step="any" class="form-control" name="txtEditarPrecioProducto" placeholder="Precio del producto" required> 
          </div>
          <input type="hidden" name="idProducto">
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </div>
        <?php
          $agregarProducto = new ControladorProducto();
          $agregarProducto->ctrEditarProducto();
        ?>
      </form>
    </div>
  </div>
</div>