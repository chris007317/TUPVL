
$(document).ready(function (event){
  var leche = [];
  var avena = [];
  var meses = [];
  var datos = new FormData();
  datos.append('funcion', 'mostrarDatos');
  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }
  var mode      = 'index'
  var intersect = true
  $.ajax({
    url: "ajax/almacen.ajax.php",
    type: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success:function(response){
      let total = 0;
      for (var i = response.length - 1; i >= 0; i--) {
        meses.push(response[i]['meses']);
        leche.push(response[i]['leche']);
        avena.push(response[i]['avena']);       
        total += response[i]['avena'] + response[i]['leche'];
      }
      $('#TotalProd').html(total);
      var $salesChart = $('#graficoBarras')
      var salesChart  = new Chart($salesChart, {
        type   : 'bar',
        data   : {
          labels  : meses,
          datasets: [
            {
              backgroundColor: '#007bff',
              borderColor    : '#007bff',
              data           : leche
            },
            {
              backgroundColor: '#ced4da',
              borderColor    : '#ced4da',
              data           : avena
            }
          ]
        },
        options: {
          maintainAspectRatio: false,
          tooltips           : {
            mode     : mode,
            intersect: intersect
          },
          hover              : {
            mode     : mode,
            intersect: intersect
          },
          legend             : {
            display: false
          },
          scales             : {
            yAxes: [{
              // display: false,
              ticks    : $.extend({
                beginAtZero: true,
                // Include a dollar sign in the ticks
                callback: function (value, index, values) {
                  if (value >= 1000) {
                    value /= 1000
                    value += 'k'
                  }
                  return  value
                }
              }, ticksStyle)
            }],
            xAxes: [{
              display  : true,
              gridLines: {
                display: true
              },
              ticks    : ticksStyle
            }]
          }
        }
      })
    }
  });
  var benef = [];
  $.ajax({
    url: "ajax/beneficiario.ajax.php",
    type: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success:function(response){
      let total = 0;
      response.forEach(respuesta=>{
        benef.push(parseInt(respuesta['total']));
        total = parseInt(respuesta['total']) + total;
      });
      $('#totalBenef').html(total);
      var $visitorsChart = $('#graficoPiet')
      var visitorsChart  = new Chart($visitorsChart, {
        type: 'pie',
        data: {
          labels: ["Madres Gestantes", "Niños de 0 a 6", "Niños de 7 a 13", "Madres Lactantes", "Adulto Mayor", "Discapacitados"],
          datasets: [{
            label: "Population (millions)",
            backgroundColor: ['rgba(13, 110, 253, 0.8)','rgba(13, 202, 240, 0.8)','rgba(220, 53, 69, 0.8)', 'rgba(255, 193, 7, 0.8)', 'rgba(108, 117, 125, 0.8)', 'rgba(33, 37, 41, 0.8)'],
            data: benef
          }]
        },
        options: {
          maintainAspectRatio: false,
          tooltips           : {
            mode     : mode,
            intersect: intersect
          },
          hover              : {
            mode     : mode,
            intersect: intersect
          },
          legend             : {
            display: true
          }  
        }

      });
    }
  });
});

