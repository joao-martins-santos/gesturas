@extends('adminlte::page')

@section('title', 'Vet : MAyA')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"/>
  <!-- Morris chart -->
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/morris.js/morris.css">
   <!-- jvectormap -->
   <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/jvectormap/jquery-jvectormap.css">
   <script src="https://adminlte.io/themes/AdminLTE/bower_components/moment/min/moment.min.js"></script>
   <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css">

<style>
.selected{
   background-color: #8bb07f !important;
}
</style>
@stop

<?php
//echo $json_temp;
//var_dump($json_temp);
//die;
?>


@section('content_header')
<section class="content-header">
    <h1>{{$pet->name}} <small> [{{$pet->cod_feeder}}, {{$pet->cod_collar}}]</small></h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Serviços</a></li>
    <li><a href="/vet/service/monitoring">Acompanhamentos</a></li>
    <li class="active">Detalhes</li>
    </ol>
</section>
@stop

@section('content')

<div class="row">
  <div class="col-xs-12">
    <div class="box box-success">
      <div class="box-header with-border">
        <i class="fa fa-search"></i>
        <h3 class="box-title">Dados</h3>
      </div>

      <div class="box-body">
        <div class="row">
          <div class="col-sm-4 invoice-col" id="dadosPetDiv">
            <address id="dadosPet">
              <b>Nome:</b> {{$pet->name}}<br>
              <b>Idade:</b> {{$pet->timelife}}<br>
              <b>Sexo:</b> {{$pet->genre}}<br>
              <b>Peso:</b> {{$pet->weight}}<br>
            </address>
          </div>
          <div class="col-sm-4 invoice-col" id="dadosPetDiv">
            <address id="dadosPet">
              <b>Raça:</b> {{$pet->breed->name}}<br>
              <b>Alimentador:</b> {{$pet->cod_feeder}}<br>
              <b>Coleira:</b> {{$pet->cod_collar}}<br>
            </address>
          </div>

          <div class="col-sm-4 invoice-col" id="dadosPetDiv">
            <b>Nome:</b> {{$pet->user->name}}<br>
            <b>CPF:</b> {{$pet->user->cpf}} <br>
            <b>Data de Nascimento:</b> {{$pet->user->birtdate}}<br>
            <b>E-mail:</b> {{$pet->user->email}}<br>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-xs-12">
    <div class="box box-success">
      <div class="box-header with-border">
        <i class="fa fa-search"></i>
        <h3 class="box-title">Filtros</h3>
      </div>

      <div class="box-body">
        <div class="row">
          <div class="col-xs-4">
            <label>Data:</label>
            <div class="input-group date col-xs-12">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="reservation">
            </div>
          </div>

          <div class="col-xs-2">
            <br><button class="btn btn-success" id="btnFiltrar">Filtrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="row">
  <div class="col-xs-12">
    <div class="box box-success">
      
      <div class="box-header with-border">
        <i class="fa fa-bar-chart-o"></i>
        <h3 class="box-title">Médias Comparando <small> ( Padrão da Raça )</small></h3>
      </div>

      <div class="box-body">
        <div class="row">

          <div class="col-xs-3 text-center">
            <div class="chart" id="bar-chart1" style="height: 250px; width: 200px"></div>
          </div>
          <div class="col-xs-3 text-center">
            <div class="chart" id="bar-chart2" style="height: 250px; width: 200px"></div>
          </div>
          <div class="col-xs-3 text-center">
            <div class="chart" id="bar-chart3" style="height: 250px; width: 200px"></div>
          </div>
          <div class="col-xs-3 text-center">
            <div class="chart" id="bar-chart4" style="height: 250px; width: 200px"></div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box box-success">

      <div class="box-header with-border">
        <i class="fa fa-bar-chart-o"></i>
        <h3 class="box-title">Médias do PET<small> ( Média por período )</small></h3>
      </div>

      <div class="box-body">
        <div class="row">

          <div class="col-md-3">
            <div class="small-box bg-green">
              <div class="inner">
                <h3>{{$dadosGerais->minutos}}<sup style="font-size: 15px"> minutos</sup></h3>
                <p>Movimentação</p>
              </div>
              <div class="icon">
                <i class="fa fa-balance-scale"></i>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="small-box bg-green">
                <div class="inner">
                  <h3>{{$dadosGerais->calorias}}<sup style="font-size: 15px"> Kcal </sup></h3>
                  <p>Calorias</p>
                </div>
                <div class="icon">
                  <i class="fa fa-heartbeat"></i>
                </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="small-box bg-green">
              <div class="inner">
                <h3>53<sup style="font-size: 15px">ºC</sup></h3>
                <p>Temperatura</p>
              </div>
              <div class="icon">
                <i class="fa fa-exclamation"></i>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="small-box bg-green">
              <div class="inner">
                <h3>{{$dadosGerais->passos}}</h3>
                <p>Qtd Passos</p>
              </div>
              <div class="icon">
                <i class="fa fa-exclamation"></i>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">

  <div class="col-md-8">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Temperatura<small> ( Ambiente )</small></h3>
      </div>
      <div class="box-body chart-responsive">
        <div class="chart" id="line-chart1" style="height: 300px;"></div>
      </div>
    </div>
  </div>


  <div class="col-md-4">

    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Luminosidade<small> ( Ambiente )</small></h3>
      </div>
      <div class="box-body chart-responsive">
        <div class="info-box bg-yellow">
          <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Claro</span>
            <span class="info-box-number">{{$luminosidades->claro}}%</span>
          </div>
        </div>
        <div class="info-box bg-yellow">
          <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Sombra</span>
            <span class="info-box-number">{{$luminosidades->sombra}}%</span>
          </div>
        </div>
        <div class="info-box bg-yellow">
          <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Escuro</span>
            <span class="info-box-number">{{$luminosidades->escuro}}%</span>
          </div>
        </div>
      </div>
    </div>
    
  </div>

</div>

<div class="row">

  <div class="col-md-8">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Posições<small> ( Padrão da Raça )</small></h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="chart-responsive">
              <canvas id="pieChart" height="150"></canvas>
            </div>
          </div>
          <div class="col-md-6">
            <div class="chart-responsive">
              <canvas id="pieChart2" height="150"></canvas>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <ul class="chart-legend clearfix">
              <i class="fa fa-circle-o text-green"></i> Em Pé &nbsp;
              <i class="fa fa-circle-o text-yellow"></i> Sentado &nbsp;
              <i class="fa fa-circle-o text-aqua"></i> Deitado &nbsp;
            </ul>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Mapa</h3>
      </div>
      <div class="box-body no-padding">
        <div class="pad">
          <div id="world-map-markers" style="height: 425px;"></div>
        </div>
      </div>
    </div>
  </div>

</div>

@stop

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/raphael/raphael.min.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/bower_components/morris.js/morris.min.js"></script>
<!-- ChartJS -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/chart.js/Chart.js"></script>
<!-- jQuery Knob -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery-knob/js/jquery.knob.js"></script>
<!-- jvectormap  -->
<script src="https://adminlte.io/themes/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="http://jvectormap.com/js/jquery-jvectormap-south_america-mill.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>


<script>
    (function($){

    $( "#btnFiltrar" ).click(function() {
        alert( $('#reservation').val() );
        //"09/30/2019 - 09/30/2019"
    });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, locale: { format: 'DD/MM/YYYY hh:mm A' }})
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    /*
      getChart = function(dt_ini, dt_fim){
        return $.ajax({
            url: '/vet/service/monitoring/chats-temp/' + dt_ini+ '/' +dt_fim,
            method: 'GET',
            dataType:"json",
            async: false
        });
      };
    */
    
     var response = <?php echo $json_temp ?>; // getChart("2019-09-16","2019-09-16");

      // LINE CHART
      var line = new Morris.Line({
        element: 'line-chart1',
        resize: true,
        data: response.responseJSON,
        xkey: 'year',
        ykeys: 'value',
        parseTime: true,
        labels: ['Temperatura'],
        lineColors: ['#3c8dbc'],
        hideHover: 'auto',
        pointSize: 2,
        resize: true
      });

    
      //"use strict";

    /* jVector Maps */
      $('#world-map-markers').vectorMap({
        map              : 'south_america_mill',
        normalizeFunction: 'polynomial',
        hoverOpacity     : 0.7,
        hoverColor       : false,
        backgroundColor  : 'transparent',
        regionStyle      : {
          initial      : {
            fill            : 'rgba(210, 214, 222, 1)',
            'fill-opacity'  : 1,
            stroke          : 'none',
            'stroke-width'  : 0,
            'stroke-opacity': 1
          },
          hover        : {
            'fill-opacity': 0.7,
            cursor        : 'pointer'
          },
          selected     : {
            fill: 'yellow'
          },
          selectedHover: {}
        },
        markerStyle      : {
          initial: {
            fill  : '#00a65a',
            stroke: '#111'
          }
        },
        markers          : [
          { latLng: [-7.97, -35.01], name: 'Aldeia'},
          { latLng: [-8.04, -34.93], name: 'Caxangá'}
        ]
      });


    //-------------
    //- PIE CHART 1 -
    //-------------
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var pieChart       = new Chart(pieChartCanvas);
    var PieData        = [
      {
        value    : <?php echo $posicoes->empe ?>,
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'Em Pé '
      },
      {
        value    : <?php echo $posicoes->sentado ?>,
        color    : '#f39c12',
        highlight: '#f39c12',
        label    : 'Sentado'
      },
      {
        value    : <?php echo $posicoes->deitado ?>,
        color    : '#00c0ef',
        highlight: '#00c0ef',
        label    : 'Deitado'
      }
    ]

    var pieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);


 //-------------
    //- PIE CHART 2 -
    //-------------
    var pieChartCanvas2 = $('#pieChart2').get(0).getContext('2d');
    var pieChart2       = new Chart(pieChartCanvas2);
    var PieData2        = [
      {
        value    : 50,
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'Em Pé '
      },
      {
        value    : 30,
        color    : '#f39c12',
        highlight: '#f39c12',
        label    : 'Sentado'
      },
      {
        value    : 20,
        color    : '#00c0ef',
        highlight: '#00c0ef',
        label    : 'Deitado'
      }
    ]

    var pieOptions2     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart2.Doughnut(PieData2, pieOptions2);


    



    /* jQueryKnob */

    $(".knob").knob({
      /*change : function (value) {
       //console.log("change : " + value);
       },
       release : function (value) {
       console.log("release : " + value);
       },
       cancel : function () {
       console.log("cancel : " + this.value);
       },*/
      draw: function () {
        // "tron" case
        if (this.$.data('skin') == 'tron') {

          var a = this.angle(this.cv)  // Angle
              , sa = this.startAngle          // Previous start angle
              , sat = this.startAngle         // Start angle
              , ea                            // Previous end angle
              , eat = sat + a                 // End angle
              , r = true;

          this.g.lineWidth = this.lineWidth;

          this.o.cursor
          && (sat = eat - 0.3)
          && (eat = eat + 0.3);

          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value);
            this.o.cursor
            && (sa = ea - 0.3)
            && (ea = ea + 0.3);
            this.g.beginPath();
            this.g.strokeStyle = this.previousColor;
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
            this.g.stroke();
          }

          this.g.beginPath();
          this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
          this.g.stroke();

          this.g.lineWidth = 2;
          this.g.beginPath();
          this.g.strokeStyle = this.o.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
          this.g.stroke();

          return false;
        }
      }
    });
    /* END JQUERY KNOB */



    //BAR CHART
    var bar = new Morris.Bar({
      element: 'bar-chart1',
      //resize: true,
      data: [
        {y: 'Peso(kg)', a: 45, b: 43}
      ],
      barColors: ['#00a65a', '#f56954'],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Raça', 'Seu PET'],
      hideHover: 'auto'
    });

    var bar = new Morris.Bar({
      element: 'bar-chart2',
      //resize: true,
      data: [
        {y: 'Calorias(kcal)', a: 90, b: 150}
      ],
      barColors: ['#00a65a', '#f56954'],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Raça', 'Seu PET'],
      hideHover: 'auto'
    });

    var bar = new Morris.Bar({
      element: 'bar-chart3',
      //resize: true,
      data: [
        {y: 'Temperatura(ºC)', a: 25, b: 35}
      ],
      barColors: ['#00a65a', '#f56954'],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Raça', 'Seu PET'],
      hideHover: 'auto'
    });

    var bar = new Morris.Bar({
      element: 'bar-chart4',
      //resize: true,
      data: [
        {y: 'Alimentação(Kg)', a: 400, b: 500}
      ],
      barColors: ['#00a65a', '#f56954'],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Raça', 'Seu PET'],
      hideHover: 'auto'
    });

    }(jQuery));
</script>
@stop
