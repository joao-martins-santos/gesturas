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

<?php //dd(auth()->user()); ?>

@section('content_header')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Serviços</a></li>
        <li><a href="/vet/service/consult">Banho & Tosa</a></li>
        <li class="active">Novo Banho & Tosa</li>
    </ol>
</section>
@stop

@section('content')
<br />
<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
            <i class="fa fa-hospital-o"></i> Banho & Tosa
            <small class="pull-right">Data: <?php echo date("d/m/Y")?></small>
            </h2>
        </div>
    </div>

    <div class="row">
    
    <form id="userForm" name="userForm">
        <div class="box-body">
          <div class="row">
            <div class="col-xs-6">
              <div class="form-group">
                <label>Código Pet</label>
                <div class="input-group col-xs-4">
                    <input type="text" class="form-control" id="edtCodigo" name="etdIdPet">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" id="btnGo">Go!</button>
                    </span>
                </div>
              </div>
            </div>
          </div>

            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col" id="dadosPetDiv">
                    <address id="dadosPet">
                        <strong>Dados do PET</strong><br>
                        <b>Nome:</b> <br>
                        <b>Idade:</b><br>
                        <b>Sexo:</b> <br>
                        <b>Peso:</b> <br>
                    </address>
                </div>
                <div class="col-sm-4 invoice-col" id="dadosTutorDiv">
                    <address id="dadosTutor">
                        <strong>Dados do Tutor</strong><br>
                        <b>Nome:</b> <br>
                        <b>CPF:</b> <br>
                        <b>Data de Nascimento:</b> <br>
                        <b>E-mail:</b> <br>
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong>Dados do Veterinário</strong><br>
                        <b>Nome:</b> Dr(a). {{auth()->user()->name}}<br>
                        <b>CRMV:</b> {{auth()->user()->crmv}}<br>
                        <b>Especialidade:</b> Clinico Geral, Cirurgião, Dermatologista
                    </address>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h3 class="page-header"><i class="fa fa-medkit"></i> Informaçẽos do Banho</h3>
                    <button type="button" class="btn btn-primary pull-right"  data-toggle="modal" data-target="#modal-default">
                        <i class="fa fa-download"></i> Produtos
                    </button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="box-body">
                    <table id="example" name="example">
                        <thead>
                            <tr>
                                <th>Quantidade</th>
                                <th>Tipo</th>
                                <th>Medicamento</th>
                                <th>Principio</th>
                                <th>Posologia</th>
                                <th>Dosagem</th>
                                <th>Observação</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Quantidade</th>
                                <th>Tipo</th>
                                <th>Medicamento</th>
                                <th>Principio</th>
                                <th>Posologia</th>
                                <th>Dosagem</th>
                                <th>Observação</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="page-header"><i class="fa fa-medkit"></i> Informaçẽos da Tosa</h3>
                    <button type="button" class="btn btn-primary pull-right"  data-toggle="modal" data-target="#modal-default">
                        <i class="fa fa-download"></i> Produtos
                    </button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="box-body">
                    <table id="example" name="example">
                        <thead>
                            <tr>
                                <th>Quantidade</th>
                                <th>Tipo</th>
                                <th>Medicamento</th>
                                <th>Principio</th>
                                <th>Posologia</th>
                                <th>Dosagem</th>
                                <th>Observação</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Quantidade</th>
                                <th>Tipo</th>
                                <th>Medicamento</th>
                                <th>Principio</th>
                                <th>Posologia</th>
                                <th>Dosagem</th>
                                <th>Observação</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h3 class="page-header"><i class="fa fa-medkit"></i> Observações</h3>
                    <div class="form-group">
                        <label>Instrução</label>
                          <textarea class="form-control" id="edtDescricao" name="edtDescricao" rows="5" ></textarea>
                    </div>
                </div>
            </div>
            
             <div class="col-xs-12">
                <button type="button" id="btnFinalizar" class="btn btn-success pull-right">Finalizar Exame</button>
            </div>
        </div>
    </form>

    </div>
</section>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar Medicamentos</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label>Tipo de Medicamento</label>
                  <select class="form-control" id="edtTipoMedicamento">
                    <option value="">Escolha uma das opções</option>
                    <option value="Analgésico">Analgésico</option>
                    <option value="Antiemética">Antiemética</option>
                    <option value="Anticonvulsivantes">Anticonvulsivantes</option>
                    <option value="Solução Aquosa">Solução Aquosa</option>
                    <option value="Quinolonas">Quinolonas</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Medicamento</label>
                  <input type="text" id="edtMedicamento" class="form-control">
                </div>
                <div class="form-group">
                  <label>Principio Ativo</label>
                  <input type="text" id="edtPrincipioAtivo" class="form-control">
                </div>
                <div class="form-group">
                  <label>Quantidade</label>
                  <input type="text" id="edtQtd" class="form-control">
                </div>
                <div class="form-group">
                  <label>Posologia</label>
                  <input type="text" id="edtPosologia" class="form-control">
                </div>
                <div class="form-group">
                  <label>Dosagem</label>
                  <input type="text" id="edtDosagem" class="form-control">
                </div>
                <div class="form-group">
                  <label>Observação</label>
                  <textarea class="form-control" id="edtObservacao" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button id="addMedicamento" type="button" class="btn btn-primary" data-dismiss="modal">Salvar Medicamento</button>
            </div>
        </div>
    </div>
</div>


@stop

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

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

    var table = $('#example').DataTable(confPTbrDt);

    $("#addMedicamento").click(function() {
        table.row.add( [
            $('#edtQtd').val(),
            $('#edtTipoMedicamento').val(),
            $('#edtMedicamento').val(),
            $('#edtPrincipioAtivo').val(),
            $('#edtPosologia').val(),
            $('#edtDosagem').val(),
            $('#edtObservacao').val()
        ] ).draw( false );
    });



} );

$(function(){

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

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
        var table = $('#example').DataTable();
        var dados = table.rows().data();

        console.log($('#userForm').serialize());

        if($("#edtCodigo").val() == '' ){
            alert("Favor adicionar um PET!");
            $("#edtCodigo").focus();
            return false;
        }

       /* if( data.length == 0 ){
            alert("Favor adicionar um ou mais medicamentos!");
        }*/

   // 


    //data: $('#userForm').serialize(),
    var data = table.serialize();

    console.log( data );

/*
        $("#userForm").validate({
            submitHandler: function(form) {
                $.ajax({
                    data : $('#userForm').serialize(),
                    url: "/vet/service/consult/store",
                    type: "POST",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log(data);

                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        });
  */          




/*
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
        */

    });
    
}(jQuery));
</script>
@stop