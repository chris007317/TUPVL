$(document).on('change', '#cmbPeriodoProducto', function(){
  $("#cmbPeriodoProducto").find("option[value='']").remove();
  let nombreProducto = $(this).val();
  if (nombreProducto != '') {
    $('#tableProgramaProductos').html('');
    $('#tableProductosEntregar').html('');
    arregloMes = []
    /* ver la cantidad de productos que hay */
    let datos = new FormData();
    datos.append('yearPerido', $('input[name="yearPerido"]').val());  
    datos.append("nombreProducto", nombreProducto);
    datos.append("estado", 1);
    datos.append("funcion", 'verCantidadProducto');
    
    let datos1 = new FormData();
    datos1.append("nombreProducto", nombreProducto); 
    datos1.append("funcion", 'verPeriodos');
    let template = '';
    let check = '';
    $.ajax({
      url:"ajax/municipalidad.ajax.php",
      method: "POST",
      data: datos1,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
        response.forEach(valor =>{
          if (valor.estado == 'true') {
            check =`<input class="custom-control-input checkPeriodo" type="checkbox" id="checkMesPeriodo${valor.id}" name="checkMesPeriodo${valor.id}" value="${valor.id}" disabled checked>`;
          }else{
            check =`<input class="custom-control-input checkPeriodo" type="checkbox" id="checkMesPeriodo${valor.id}" name="checkMesPeriodo${valor.id}" value="${valor.id}">`;
          }
          template +=`
            <div class="custom-control custom-checkbox">
              ${check}
              <label for="checkMesPeriodo${valor.id}" class="custom-control-label">${valor.mes}</label>                         
            </div>
          `;
        });
        meses = 0;
        totalProd = 0;
        $('#mesesPeriodo').html(template);
        $('#productosPeriodo').html(0);
        $('#prodRepartir, #validar').removeClass('bg-danger');
        $('#prodRepartir, #validar').addClass('bg-info'); 
        cantidadProducto(datos);
      }
    });
  }
});

$(document).on('change', '.checkPeriodo', function(){
  let totalBenef = $('input[name="totalBeneficiarios"]').val(); 
  let totalProductos = $('input[name="totalProductos"]').val(); 
  enviar = false;
  $('#tableProgramaProductos').html(''); 
  $('#tableProductosEntregar').html('');
  if($(this).prop('checked')){
    meses = meses + 1;
    arregloMes.push($(this).val());
    totalProd = Math.trunc(totalProductos / (totalBenef*meses));
  }else{
    meses = meses - 1;
    let checVal = $(this).val();
    let pos = arregloMes.indexOf(checVal)
    arregloMes.splice(pos, 1);
    totalProd = Math.trunc(totalProductos / (totalBenef*meses));
  }
  if (totalProd > 0 && totalProd <= totalProductos) {
    $('#validar').html('Valido');
    $('#productosPeriodo').html(totalProd);
    $('#prodRepartir, #validar').removeClass('bg-danger');
    $('#prodRepartir, #validar').addClass('bg-info');
    calcular = true;
  }else{
    $('#productosPeriodo').html(0);
    $('#prodRepartir, #validar').removeClass('bg-info');
    $('#prodRepartir, #validar').addClass('bg-danger');
    $('#validar').html('No valido');
    calcular = false;
  }
});

var meses = 0;
var totalProd = 0;
var calcular = false;
var enviar = false;
var arregloMes = [];

function cantidadProducto(datos){
  $.ajax({
    url:"ajax/almacen.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success:function(response){
      $('input[name="totalBeneficiarios"]').val(response.total);
      $('#totalBenef').html(response.total)
      $('#productosDisponibles').html(response.disponible);
      $('input[name="totalProductos"]').val(response.disponible); 
      $('#productosTotal').html(response.disponible);
      for (var i = 1; i < response.mes; i++) {
        $('#checkMesPeriodo'+i).attr('disabled', 'disabled');
      }
    }
  });
}

$(document).on('submit', '#formProgramarPeriodo', function(event){
  if (calcular == false) {
    mensaje('Advertencia', '¡Los datos no son validos!', 'error');
  }else{
    enviar = false;
    let template = '';
    $.ajax({
      url:"ajax/municipalidad.ajax.php",
      method: "POST",
      data: $('#formProgramarPeriodo').serialize(),
      cache: false,
      processData: false,
      dataType: "json",
      success:function(response){
        $('#tableProgramaProductos').html(response.tabla1);
        $('#tableProductosEntregar').html(response.tabla2);
        enviar = true;
      }
    });
  }
  event.preventDefault();
});

$(document).on('click', '#btnGuardarPrograma', function(){
  if (enviar == false) {
    mensaje('Advertencia', '¡Los datos no son validos!', 'error');
  }else{
    swal({
      title: "Advertencia",
      text: "Una vez realizada el programa de entrega no podra registrar nuevos beneficiarios hasta realizar las entregas de alimentos",
      type: "warning",
      showConfirmButton: true,
      confirmButtonText: "¡Si, Generar!",
      showCancelButton: true,
      cancelButtonText: "¡Cancelar!"
    }).then(function(result){
      if(result.value){
        let totalBenef = $('input[name="totalBeneficiarios"]').val(); 
        let totalProductos = $('input[name="totalProductos"]').val(); 
        let year = $('input[name="yearPerido"]').val(); 
        let nombreProducto = $('#cmbPeriodoProducto').val();
        let datos = new FormData();
        datos.append("totalBeneficiarios", totalBenef);
        datos.append("totalProductos", totalProductos);
        datos.append("yearPeriodo", year);
        datos.append("meses", arregloMes);
        datos.append("nombreProducto", nombreProducto);
        datos.append("funcion", 'guardarPrograma');
        $.ajax({
          url:"ajax/municipalidad.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success:function(response){
            if (response == 'ok') {
              mensajeReload('¡CORRECTO!', '¡Los datos fueron guardados con exito!', 'success');
            }else{
              mensaje('Error', '¡Ah ocurrido un error! comuniquese con el administrador de inmediato', 'error');
            }
          }
        });
      }
    });
  }
}); 