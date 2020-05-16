@extends('adminlte::page')

@section('title', 'Vet : MAyA')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>

<style>
.selected{
   background-color: #8bb07f !important;
}
</style>
@stop

<?php // dd($pet); ?>

@section('content_header')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Serviços</a></li>
        <li><a href="/vet/service/monitoring">Acompanhamento</a></li>
        <li class="active">Cartão de Vacina</li>
    </ol>
</section>
@stop

@section('content')
<br />
<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
              <i class="fa fa-hospital-o"></i> Cartão de Vacina
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="box-body">
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col" id="dadosPetDiv">
                    <address id="dadosPet">
                        <strong>Dados do PET</strong><br>
                          <b>Nome:</b> {{$pet->name}}<br>
                          <b>Raça:</b> {{$pet->breed->name}}<br>
                          <b>Idade:</b> {{$pet->timelife}}<br>
                    </address>
                </div>
                <div class="col-sm-4 invoice-col" id="dadosTutorDiv">
                    <address id="dadosTutor">
                        <strong>&nbsp;</strong><br>
                        <b>Sexo:</b> {{$pet->genre}}<br>
                        <b>Peso:</b> {{$pet->weight}}<br>
                        <b>Castração:</b> Sim<br>
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong>Dados do Tutor</strong><br>
                        <b>Nome:</b> {{$pet->user->name}}<br>
                        <b>CPF:</b> {{$pet->user->cpf}} <br>
                        <b>Data de Nascimento:</b> {{$pet->user->birtdate}}<br>
                        <b>E-mail:</b> {{$pet->user->email}}<br>
                    </address>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h3 class="page-header"><i class="fa fa-eyedropper"></i> Vacinas</h3>
                </div>
            </div>


            <div class="col-md-3">
                <div class="box box-success direct-chat direct-chat-success">
                    <div class="box-header with-border">
                    <h3 class="box-title">Vacina</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                        <i class="fa fa-comments"></i></button>
                    </div>
                    </div>
                    <div class="box-body">
                    <div class="direct-chat-messages">
                        <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left">Dr. Alexander Pierce</span>
                                <span class="direct-chat-timestamp pull-right">23/01/19 14:31</span>
                            </div>
                            Tipo: Raiva <br> 
                            Fab: Nov/15 <br>
                            Venc: Mai/17
                        </div>
                        <div class="direct-chat-msg right">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-right">Sarah Bullock</span>
                            <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                        </div>
                        <img class="direct-chat-img" src="../dist/img/user3-128x128.jpg" alt="Message User Image"><!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            You better believe it!
                        </div>
                        </div>
                    </div>
                    <div class="direct-chat-contacts">
                        <ul class="contacts-list">
                        <li>
                            <a href="#">
                                <img height="100px" src="{{url('/images/V1.png')}}" alt="User Image">
                                <div class="contacts-list-info">
                                    <span class="contacts-list-name">
                                        Part: <small class="contacts-list-date pull-right">015 / 2015 </small>
                                    </span>
                                    <span class="contacts-list-name">
                                        Fab: <small class="contacts-list-date pull-right">Nov / 2015</small>
                                    </span>
                                    <span class="contacts-list-name">
                                        Venc: <small class="contacts-list-date pull-right">Mai / 2015</small>
                                    </span>
                                </div>
                            </a>
                        </li>
                        </ul>
                    </div>
                    </div>
                    <div class="box-footer">
                    <form action="#" method="post">
                        <div class="input-group">
                        <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success btn-flat">Send</button>
                            </span>
                        </div>
                    </form>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="box-body">
                    <div class="box-body">
                        <table id="tbl_vacina" class="display" style="width:100%">
                            <thead>
                                <tr>
                                  <th>Data</th>
                                  <th>Vacina</th>
                                  <th>Observação</th>
                                  <th>Veterinário</th>
                                  <th>Repetir</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                  <th>Data</th>
                                  <th>Vacina</th>
                                  <th>Observação</th>
                                  <th>Veterinário</th>
                                  <th>Repetir</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;" data-toggle="modal" data-target="#modal-vacina">Adicionar Vacina</button>
            </div>

            <div class="row">
              <div class="col-xs-12">
                  <h3 class="page-header"><i class="fa fa-medkit"></i> Vermífugos</h3>
              </div>
            </div>
            <div class="row">
                <div class="box-body">
                    <div class="box-body">
                        <table id="tbl_vermifugos" class="display" style="width:100%">
                            <thead>
                                <tr>
                                  <th>Data</th>
                                  <th>Vermífugo</th>
                                  <th>Observação</th>
                                  <th>Veterinário</th>
                                  <th>Reforço</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                  <th>Data</th>
                                  <th>Vermífugo</th>
                                  <th>Observação</th>
                                  <th>Veterinário</th>
                                  <th>Reforço</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;" data-toggle="modal" data-target="#modal-vermifugo">Adicionar Vermífugo</button>
            </div>
        </div>
    </div>

</section>

<div class="modal fade" id="modal-vacina">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar Vacina</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label>Data da Aplicação</label>
                  <input type="text" id="edtData" class="form-control" >
                </div>
                <div class="form-group">
                  <label>Vacina Aplicada</label>
                  <select class="form-control" id="edtVacina">
                    <option value="option 1">option 1</option>
                    <option value="option 2">option 2</option>
                    <option value="option 3">option 3</option>
                    <option value="option 4">option 4</option>
                    <option value="option 5">option 5</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Veterinário</label>
                  <input type="text" id="edtVeterinario" class="form-control">
                </div>
                <div class="form-group">
                  <label>Observação</label>
                  <textarea class="form-control" id="edtObservacao" rows="3"></textarea>
                </div>
                <div class="form-group">
                  <label>Data para repetir</label>
                  <input type="text" id="edtRepetir" class="form-control" >
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button id="addVacina" type="button" class="btn btn-success pull-right" data-dismiss="modal">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-vermifugo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar Vermífugo</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label>Data da Aplicação</label>
                  <input type="text" id="edtDataVermifugo" class="form-control" >
                </div>
                <div class="form-group">
                  <label>Vermífugo Aplicada</label>
                  <select class="form-control" id="edtVermifugo">
                    <option value="option 1">option 1</option>
                    <option value="option 2">option 2</option>
                    <option value="option 3">option 3</option>
                    <option value="option 4">option 4</option>
                    <option value="option 5">option 5</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Veterinário</label>
                  <input type="text" id="edtVeterinarioVermifugo" class="form-control">
                </div>
                <div class="form-group">
                  <label>Dose</label>
                  <input type="text" id="edtDose" class="form-control">
                </div>
                <div class="form-group">
                  <label>Reforço</label>
                  <input type="text" id="edtReforco" class="form-control">
                </div>
                <div class="form-group">
                  <label>Observação</label>
                  <textarea class="form-control" id="edtObservacaoVermifugo" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button id="addVermifugo" type="button" class="btn btn-success pull-right" data-dismiss="modal">Salvar</button>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script>

var confPTbrDt = {
              "language": {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                  "sNext": "Próximo",
                  "sPrevious": "Anterior",
                  "sFirst": "Primeiro",
                  "sLast": "Último"
                },
                "oAria": {
                  "sSortAscending": ": Ordenar colunas de forma ascendente",
                  "sSortDescending": ": Ordenar colunas de forma descendente"
                }
              }
            };

$(document).ready(function() {

    $('#tbl_vacina').DataTable(confPTbrDt);
    $("#addVacina").click(function() {
        var t = $('#tbl_vacina').DataTable(confPTbrDt);
        t.row.add( [
            $('#edtData').val(),
            $('#edtVacina').val(),
            $('#edtObservacao').val(),
            $('#edtVeterinario').val(),
            $('#edtRepetir').val()
        ] ).draw( false );
    });

    $('#tbl_vermifugos').DataTable(confPTbrDt);
    $("#addRow").click(function() {
        var t = $('#tbl_vermifugos').DataTable(confPTbrDt);
        t.row.add( [
            $('#edtDataVermifugo').val(),
            $('#edtVermifugo').val(),
            $('#edtObservacaoVermifugo').val(),
            $('#edtVeterinarioVermifugo').val(),
            $('#edtReforco').val()
        ] ).draw( false );
    });

} );





(function($){
    $('#btnGo').click(function(){
        var num = $('#edtCodigo').val();
        $.ajax({
            method: 'GET',
            url: '/vet/service/consult/pet-user-cod/' + num,
            success: function (data) {
                var html =  '<address id="dadosPet">' +
                            '<strong>Dados do PET</strong><br>'+
                            '<b>Nome: </b>' + data.namePET + '<br>' +
                            '<b>Idade: </b>' + data.timelifePET + '<br>' +
                            '<b>Sexo: </b>' + data.genrePET + '<br>' +
                            '<b>Peso: </b>' + data.weightPET + '<br>' +
                            '</address>';
                $('#dadosPet').remove();
                $('#dadosPetDiv').append(html);
         
                var html =  '<address id="dadosTutor">' +
                            '<strong>Dados do Tutor</strong><br>'+
                            '<b>Nome: </b>' + data.nameUser + '<br>' +
                            '<b>CPF: </b>' + data.cpfUser + '<br>' +
                            '<b>Data de Nascimento: </b>' + data.birtdateUser + '<br>' +
                            '<b>E-mail: </b>' + data.emailUser + '<br>' +
                            '</address>';
                $('#dadosTutor').remove();
                $('#dadosTutorDiv').append(html);
            },
            error: function (data) {
            }
        });
    });






    $('#btnFinalizar').click(function(){
        var table = $('#tbl_vacina').DataTable(confPTbrDt);
        var data = table.rows().data();

        if($("#edtCodigo").val() == '' ){
            alert("Favor adicionar um PET!");
            $("#edtCodigo").focus();
            return false;
        }

        if( data.length == 0 ){
            alert("Favor adicionar um ou mais medicamentos!");
        }

        $.ajax({
            method: 'GET',
            url: '/vet/service/consult/pet-user-cod/' + num,
            success: function (data) {
                var html =  '<address id="dadosPet">' +
                            '<strong>Dados do PET</strong><br>'+
                            '<b>Nome: </b>' + data.namePET + '<br>' +
                            '<b>Idade: </b>' + data.timelifePET + '<br>' +
                            '<b>Sexo: </b>' + data.genrePET + '<br>' +
                            '<b>Peso: </b>' + data.weightPET + '<br>' +
                            '</address>';
                $('#dadosPet').remove();
                $('#dadosPetDiv').append(html);
         
                var html =  '<address id="dadosTutor">' +
                            '<strong>Dados do Tutor</strong><br>'+
                            '<b>Nome: </b>' + data.nameUser + '<br>' +
                            '<b>CPF: </b>' + data.cpfUser + '<br>' +
                            '<b>Data de Nascimento: </b>' + data.birtdateUser + '<br>' +
                            '<b>E-mail: </b>' + data.emailUser + '<br>' +
                            '</address>';
                $('#dadosTutor').remove();
                $('#dadosTutorDiv').append(html);
            },
            error: function (data) {
            }
        });        
        
    });
    
}(jQuery));
</script>
@stop