@extends('adminlte::page')

@section('title', 'Vet : MAyA')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"/>
  <!-- Morris chart -->
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/morris.js/morris.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
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
  //var_dump( $posicoes, $posicoes->empe);
  //die;
 //dd($json_temp);
 $rows = array( array('cron_time'=>'2015-02-04 21:05:34', 'images_processed'=>65), array('cron_time'=>'2015-02-04 22:05:34', 'images_processed'=>70), array('cron_time'=>'2015-02-04 23:05:34', 'images_processed'=>75) );
 //dd($json_temp, $rows);
//     
?>


@section('content_header')
<section class="content-header">
    <h1>{{$pet->name}} <small> [{{$pet->cod_feeder}}, {{$pet->cod_collar}}]</small></h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Serviços</a></li>
    <li><a href="/vet/service/monitoring">Acompanhamentos</a></li>
    <li class="active">Monitoramento</li>
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
              <input type="text" class="form-control pull-right" value="<?php echo $datas['inicial'] .' - '. $datas['final']?>" id="reservation">
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

          <div class="col-xs-6 text-center">
            <div class="chart" id="bar-chart1" style="height: 250px; width: 200px"></div>
          </div>
          
          <div class="col-xs-6 text-center">
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
                <h3>{{$dadosGerais['Passo']->minutos}}<sup style="font-size: 15px"> minutos</sup></h3>
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
                  <h3>{{$dadosGerais['Passo']->calorias}}<sup style="font-size: 15px"> Kcal </sup></h3>
                  <p>Calorias</p>
                </div>
                <div class="icon">
                  <i class="fa fa-heartbeat"></i>
                </div>
            </div>
          </div>

          <div class="col-md-2">
            <div class="small-box bg-green">
              <div class="inner">
                <h3>{{$dadosGerais['Temperatura']->Temp}}<sup style="font-size: 15px">ºC</sup></h3>
                <p>Temperatura</p>
              </div>
              <div class="icon">
                <i class="fa fa-exclamation"></i>
              </div>
            </div>
          </div>

          <div class="col-md-2">
            <div class="small-box bg-green">
              <div class="inner">
                <h3>{{$dadosGerais['Temperatura']->Umid}}<sup style="font-size: 15px">%</sup></h3>
                <p>Umidade</p>
              </div>
              <div class="icon">
                <i class="fa fa-exclamation"></i>
              </div>
            </div>
          </div>

          <div class="col-md-2">
            <div class="small-box bg-green">
              <div class="inner">
                <h3>{{$dadosGerais['Passo']->passos}}</h3>
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
        <div class="chart" id="line-chart1" ></div>
      </div>
    </div>
  </div>


  <div class="col-md-4">

    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Luminosidade<small> ( Ambiente )</small></h3>
      </div>
      <div class="box-body chart-responsive">
        
      <div class="info-box bg-orange">
          <span class="info-box-icon"><i class="fa fa-sun-o"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Claro</span>
            <span class="info-box-number">{{$dadosGerais['Luminosidade']->claro}} %</span>
          </div>
        </div>

        <div class="info-box bg-gray">
          <span class="info-box-icon"><i class="fa fa-tree"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Sombra</span>
            <span class="info-box-number">{{$dadosGerais['Luminosidade']->sombra}} %</span>
          </div>
        </div>

        <div class="info-box bg-black">
          <span class="info-box-icon"><i class="fa fa-moon-o"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Escuro</span>
            <span class="info-box-number">{{$dadosGerais['Luminosidade']->escuro}} %</span>
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
        <h3 class="box-title">Posições<small> ( % Tempo comparado com o padrão da raça )</small></h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="chart-responsive">
                @if( ($dadosGerais['Posicao']->empe == 0 && $dadosGerais['Posicao']->deitado == 0 && $dadosGerais['Posicao']->sentado == 00  ) )
                  Nenhuma dado registrado no período
                @else
                  Seu Pet 
                @endif
                <canvas id="pieChart" height="150"></canvas>
            </div>
          </div>
          <div class="col-md-6">
            <div class="chart-responsive">
              Padrão da Raça
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
      <h3 class="box-title">Posições<small> ( em horas )</small></h3>
      </div>
      <div class="box-body no-padding">
        <div class="box-body box-profile">
          <h3 class="profile-username text-center">Total: {{$dadosGerais['Posicao']->totalHoras}} hrs</h3>
        </div> 

        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="{{url('/images/empe.jpg')}}"  />
          <p class="text-muted text-center">{{$dadosGerais['Posicao']->empeHoras}} hrs</p>
        </div> 
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="{{url('/images/sentado.jpg')}}"  />
          <p class="text-muted text-center">{{$dadosGerais['Posicao']->sentadoHoras}} hrs</p>
        </div>
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="{{url('/images/deitado.jpg')}}" />
          <p class="text-muted text-center">{{$dadosGerais['Posicao']->deitadoHoras}} hrs</p>
        </div>
          <!--
          <div id="world-map-markers" style="height: 425px;"></div>
          -->
      </div>
    </div>
  </div>

</div>

@stop

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
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
        var arr      = $('#reservation').val().split(' - ');
        var dtInicio = arr[0].split("/");
        var dtFim    = arr[1].split("/");
        var url      = '/vet/service/monitoring/details/{{$pet->id}}/'+dtInicio[2]+'-'+dtInicio[1]+'-'+dtInicio[0]+'/'+dtFim[2]+'-'+dtFim[1]+'-'+dtFim[0];
        window.location = url; 
    });
    
    $("#reservation").daterangepicker({
    "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "De",
        "toLabel": "Até",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "Dom",
            "Seg",
            "Ter",
            "Qua",
            "Qui",
            "Sex",
            "Sáb"
        ],
        "monthNames": [
            "Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro"
        ],
        "firstDay": 0
    }
});


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
        endDate  : moment(),
        locale: 'pt-br',
      },
      function (start, end) {
        $('#daterange-btn span').html(start.dateFormat('dd/mm/yyyy') + ' - ' + end.dateFormat('dd/mm/yyyy'))
      }
    )

      // LINE CHART
      var line = new Morris.Line({
        element: 'line-chart1',
        data: <?php echo json_encode($json_temp);?>,
        xkey: 'year',
        ykeys: ['value'],
        labels: ['Temperatura - ºC'],
        lineColors: ['#0b62a4'],
        xLabels: 'hour',
        smooth: true,
        resize: true
    });

  
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
        value    : {{$dadosGerais['Posicao']->empe}},
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'Em Pé '
      },
      {
        value    : {{$dadosGerais['Posicao']->sentado}},
        color    : '#f39c12',
        highlight: '#f39c12',
        label    : 'Sentado'
      },
      {
        value    : {{$dadosGerais['Posicao']->deitado}},
        color    : '#00c0ef',
        highlight: '#00c0ef',
        label    : 'Deitado'
      }
    ]

    var pieOptions     = {
      segmentShowStroke    : true,
      segmentStrokeColor   : '#fff',
      segmentStrokeWidth   : 2,
      percentageInnerCutout: 50, // This is 0 for Pie charts
      animationSteps       : 100,
      animationEasing      : 'easeOutBounce',
      animateRotate        : true,
      animateScale         : false,
      responsive           : true,
      maintainAspectRatio  : true,
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }

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
      segmentShowStroke    : true,
      segmentStrokeColor   : '#fff',
      segmentStrokeWidth   : 2,
      percentageInnerCutout: 50, // This is 0 for Pie charts
      animationSteps       : 100,
      animationEasing      : 'easeOutBounce',
      animateRotate        : true,
      animateScale         : false,
      responsive           : true,
      maintainAspectRatio  : true,
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }

    pieChart2.Doughnut(PieData2, pieOptions2);

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
        {y: 'Peso(kg)', a: 45, b: {{$pet->weight}} }
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
