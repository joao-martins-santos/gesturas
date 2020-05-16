@extends('adminlte::page')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>

<style>
.selected{
   background-color: #8bb07f !important;
}
</style>
@stop

@section('content_header')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Cadastros </a></li>
        <li class="active">Registration</li>
    </ol>
</section>
@stop

@section('content')
<br />
<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header"><i class="fa fa-hospital-o"></i> Meus Registration</h2>
        </div>
    </div>

    <div class="mailbox-controls" align="center">
        <div class="btn-group">
            <div class="col-xs-6">
                <a class="btn btn-app" data-toggle="modal" data-target="#modal-default">
                    <i class="fa fa-plus"></i> Adicionar
                </a>
            </div>
        </div>
    </div>

    @if( !is_null($dados_json)>0 )
    <div class="row">
        <div class="box-body">
            <div class="row">
                <div class="box-body">
                    <table id="tbl_consulta">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Transport</th>
                                <th>Client URI</th>
                                <th>Server URI</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Transport</th>
                                <th>Client URI</th>
                                <th>Server URI</th>
                                <th>Ação</th>
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
            <p>Nenhum Registration</p>
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
                <h4 class="modal-title">Adicionar Registration</h4>
            </div>
            <div class="modal-body">
                <form id="regiForm" name="regiForm">
                    <div class="form-group">
                        <label>Id</label>
                        <input type="text" id="edtId" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Transport</label>
                        <select id="edtTransport" class="form-control">
                            <option value="">Escolher</option>
                            <?php foreach($trans as $tran){?>
                                <option value="<?php echo $tran->id?>"><?php echo $tran->id?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Client URI</label>
                        <input type="text" id="edtClientUri" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Server URI</label>
                        <input type="text" id="edtServerUri" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" onclick="createRegi()" class="btn btn-primary" data-dismiss="modal">Salvar</button>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script>

function showFile() {
    let _url = 'registration/showfile';
    $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            console.log(response);
            if( response.code == 200 ) {
                $('#textFile').val(response.data);
                $('#modal-file').modal('show');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function editEnd(event) {
    var id   = $(event).data("id");
    let _url = 'registration/edit/'+id;
    $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            console.log(response.data);
            if( response.code == 200 ) {
                $('#edtId').val(response.data.id);
                $('#edtId').prop('readonly', true);
                $('#edtClientUri').val(response.data.client_uri);
                $('#edtServerUri').val(response.data.server_uri);
                $('#edtTransporte option[value="'.response.data.transport.'"]').attr("selected", "selected");
                $('#modal-default').modal('show');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function deleteEnd(event) {
    console.log('deleteregistration');
    var id      = $(event).data("id");
    let _url    = 'registration/delete/'+id;
    let _token  = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: _url,
        type: 'DELETE',
        data: {
            _token: _token
        },
        success: function(response) {
            console.log(response);
            if(response.code == 200) {
               alert(response.message);
               location.reload();
            }
        },
        error: function(response) {
            console.log('ERROR');
            console.log(response);
        }
    });
}

function createAor() {
    var edtId        = $('#edtId').val();
    var edtTransport = $('#edtTransport').val();
    var edtClientUri = $('#edtClientUri').val();
    var edtServerUri = $('#edtServerUri').val();

    let _url     = 'registration/save';
    let _token   = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: _url,
        type: "POST",
        data: {
            edtId        : edtId,
            edtClientUri : edtClientUri,
            edtServerUri : edtServerUri,
            edtTransport : edtTransport,
            },
        success: function(response) {
            console.log(response);
            if(response.code == 200) {
                alert(response.message);
                $('#post-modal').modal('hide');
                location.reload();
            }
        },
        error: function(response) {
                console.log('ccccccc');
                console.log(response);
        }
    });
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

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
              "data": <?php echo $dados_json ?>
            };

$(document).ready(function() {
    $('#tbl_consulta').DataTable(confPTbrDt);
} );

</script>
@stop