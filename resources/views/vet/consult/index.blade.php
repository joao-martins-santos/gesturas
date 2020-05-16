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
        <li class="active">Consultas</li>
    </ol>
</section>
@stop

<?php 

//var_dump($pets_consult_json);die;

?>
@section('content')
<br />
<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header"><i class="fa fa-hospital-o"></i> Minhas Consultas</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <a href="/vet/service/consult/new" class="btn btn-primary pull-right">Adicionar Consulta</a>
        </div>
    </div>

    @if( !is_null($pets_consult_json)>0 )
    <div class="row">
        <div class="box-body">
            <div class="row">
                <div class="box-body">
                    <table id="tbl_consulta">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Pet</th>
                                <th>Raça</th>
                                <th>Tutor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Data</th>
                                <th>Pet</th>
                                <th>Raça</th>
                                <th>Tutor</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="callout callout-warning">
            <h4>Atenção!</h4>
            <p>Nenhum PET autorizado para monitoramento.</p>
        </div>
    </div>
    @endif

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
                    <option value="option 1">option 1</option>
                    <option value="option 2">option 2</option>
                    <option value="option 3">option 3</option>
                    <option value="option 4">option 4</option>
                    <option value="option 5">option 5</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Medicamento</label>
                  <input type="text" id="edtMedicamento" class="form-control" placeholder="Enter ...">
                </div>
                <div class="form-group">
                  <label>Principio Ativo</label>
                  <input type="text" id="edtPrincipioAtivo" class="form-control" placeholder="Enter ...">
                </div>
                <div class="form-group">
                  <label>Quantidade</label>
                  <input type="text" id="edtQtd" class="form-control" placeholder="Enter ...">
                </div>
                <div class="form-group">
                  <label>Instrução</label>
                  <textarea class="form-control" id="edtDescricao" rows="3" placeholder="Enter ..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button id="addRow" type="button" class="btn btn-primary" data-dismiss="modal">Salvar Medicamento</button>
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
              },
              "data": <?php echo $pets_consult_json ?>
            };

$(document).ready(function() {
    $('#tbl_consulta').DataTable(confPTbrDt);
} );


function verConsulta(id){
    alert(id);
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
    
}


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
        var table = $('#example').DataTable();
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