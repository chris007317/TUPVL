<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Consultas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Cosultas</li>
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
              <h3 class="card-title">Realizar consulta</h3>
            </div>
            <div class="card-body ">
              <div class="row">
                <div class="col-sm-5 col-12">
                  <div class="p-2" >
                    <div class="row w-100">
                      <label class="col-3 col-form-label">Elija</label>
                      <div class="col-9 form-group">
                        <select class="w-100 form-control" name="cmbTipoConsulta" id="cmbTipoConsulta">
                          <option value="">Elija opción</option>
                          <option value="1">Beneficiario</option>
                          <option value="2">Postulante</option>
                        </select>
                      </div>
                    </div>
                    <div class="row w-100">
                      <label for="txtDniPersona" class="col-3 col-form-label">DNI</label>
                      <div class="col-9 form-group">
                        <input type="text" class="w-100 form-control" id="txtDniPersona" name="txtDniPersona" placeholder="Ingrese DNI" maxlength="8" minlength="8">
                      </div>
                    </div>
                    <div class="text-center">
                      <button class="btn btn-azul" id="btnConsulta">Realizar consulta</button>
                    </div>
                  </div>
                </div>
                <div id="datosPersona" class="col-sm-7"></div>
              </div>
              <div class="table-responsive p-0">
                <table class="table table-striped" >
                  <thead>
                    <tr>
                      <th style="width: 15px;">#</th>
                      <th>Municipalidad</th>
                      <th>Comité</th>
                      <th>Tipo benef</th>
                      <th>Socio</th>
                      <th>Fec. registro</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  <tbody id="tablaConsulta">
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              
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