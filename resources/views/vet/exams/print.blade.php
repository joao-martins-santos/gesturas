<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vet::Receituário Clínico</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<?php 
//dd($pet_consult->pet, $pet_consult->vet, $prescriptionDrugs);
//die;
?>

<!-- <body onload="window.print();"> -->
<body>
<div class="wrapper">
  <section class="invoice">
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-hospital-o"></i> Receituário Clínico
          <small class="pull-right"><b>Protocolo:</b><?php echo str_pad($pet_consult->id,4,'0',STR_PAD_LEFT) ?></small>
        </h2>
      </div>
    </div>

    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <address>
          <strong>Dados do Pet</strong><br>
          Nome: {{$pet_consult->pet->name}}<br>
          Raça: {{$pet_consult->pet->breed->name}}<br>
          Idade: {{$pet_consult->pet->timelife}}<br>
          Sexo: {{$pet_consult->pet->genre}}
        </address>
      </div>
      <div class="col-sm-4 invoice-col">
        <address>
            <strong>&nbsp;</strong><br>
            Peso: {{$pet_consult->pet->weight}}<br>
            Coleira: {{$pet_consult->pet->cod_collar}} <br>
            Alimentador: {{$pet_consult->pet->cod_feeder}}<br>
        </address>
      </div>
      <div class="col-sm-4 invoice-col">
        <address>
            <strong>Dados do Tutor</strong><br>
            Nome: {{$pet_consult->pet->user->name}}<br>
            CPF: {{$pet_consult->pet->user->cpf}} <br>
            Data de Nascimento: {{$pet_consult->pet->user->birtdate}}<br>
            E-mail: {{$pet_consult->pet->user->email}}
        </address>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Quantidade</th>  
            <th>Medicação</th>
            <th>Posologia</th>
            <th>Dosagem</th>
            <th>Tipo de Medicamento</th>
            <th>Principio Ativo</th>
            <th>Observação</th>
          </tr>
          </thead>
          <tbody>
          @foreach($prescriptionDrugs as $drugs) 
          $prescriptionDrugs
          <tr>
            <td>{{$drugs->amount}}</td>
            <td>{{$drugs->medication}}</td>
            <td>{{$drugs->posology}}</td>
            <td>{{$drugs->dosage}}</td>
            <td>{{$drugs->drug_type}}</td>
            <td>{{$drugs->active_principle}}</td>
            <td>{{$drugs->comments}}</td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6">
        <p class="lead">Observação:</p>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
          {{$pet_consult->comments}}
        </p>
      </div>
          
      <div class="col-xs-6">
        <p class="lead">Dados do Veterinário</p>
        <div class="table-responsive">
          <table class="table">
            <tr><th style="width:50%">Nome:</th><td> Dr(a). {{auth()->user()->name}}</td></tr>
            <tr><th>CRMV</th><td> {{auth()->user()->crmv}}</td></tr>
            <tr><th>Especialidade:</th><td> Especialidade: Clinico Geral, Cirurgião, Dermatologista</td></tr>
          </table>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <a href="#" onclick="window.print();" class="btn btn-default"><i class="fa fa-print"></i> Imprimir</a>
      </div>
    </div>

  </section>
</div>
</body>
</html>