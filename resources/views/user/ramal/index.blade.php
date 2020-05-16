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
        <li><a href="#"><i class="fa fa-dashboard"></i>Cadastros</a></li>
        <li class="active">Ramais</li>
    </ol>
</section>
@stop

@section('content')
<br />
<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header"><i class="fa fa-hospital-o"></i> Meus Ramais</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <a class="btn btn-app" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Adicionar</a>
            <a class="btn btn-app" data-toggle="modal" data-target="#modal-file" onclick="showFile()"><i class="fa fa-file-text"></i> Ver Arquivo</a>
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
                                <th>Ramal</th>
                                <th>Transport</th>
                                <th>Context</th>
                                <th>Codecs</th>
                                <th>Password</th>
                                <th>Username</th>
                                <th>Max Contacts</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Ramal</th>
                                <th>Transport</th>
                                <th>Context</th>
                                <th>Codecs</th>
                                <th>Password</th>
                                <th>Username</th>
                                <th>Max Contacts</th>
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
            <p>Nenhum Ramal casdastrado</p>
        </div>
    </div>
    @endif
</section>

<div class="modal fade" id="modal-file">
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ver Arquivo</h4>
            </div>
            <div class="modal-body">
               <div class="form-group">
                 <textarea id="textFile" rows="40" cols="75"></textarea>
               </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar Ramal</h4>
            </div>
            <div class="modal-body">
            <form id="ramalForm" name="ramalForm">

                <div class="form-group">
                    <label>Ramal</label>
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
                    <label>NAT</label>
                    <select id="edtNat" class="form-control">
                        <option value="">Escolher</option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                        <option value="R">Roteado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Codecs</label>
                    <select id="edtAllow" class="form-control">
                        <option value="">Escolher</option>
                        <option value="ulaw">ULAW</option>
                        <option value="alaw">ALAW</option>
                        <option value="opus">OPUS</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Contexto</label>
                    <input type="text" id="edtContexto" class="form-control" value="teste-dtm">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="text" id="edtPassword" class="form-control">
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" id="edtUsername" class="form-control">
                </div>

                <div class="form-group">
                    <label>WebRTC</label>
                    <select id="edtWebRTC" class="form-control">
                        <option value="">Escolher</option>
                        <option value="yes">Sim</option>
                        <option value="no">Não</option>
                    </select>
                </div>

            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" onclick="createRamal()" class="btn btn-primary" data-dismiss="modal">Salvar</button>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>

<script>

$("#edtId").change(function() {
    $("#edtUsername").val($("#edtId").val());
 })

function showFile() {
    let _url = 'ramal/showfile';
    console.log('AAAAAAAAAA');
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

function editRamal(event) {
    var id   = $(event).data("id");
    let _url = 'ramal/edit/'+id;
    
    $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            console.log('retorno');
            console.log(response.data);
            console.log(response.data[0][0].id);

            if( response.code == 200 ) {
                $('#edtId').val(response.data.id);
                $('#edtTransport').val(response.data.transport);
                $('#edtNat').val(response.data.nat);
                $('#edtPassword').val(response.data.password);
                $('#edtUsername').val(response.data.username);
                $('#edtContexto').val(response.data.contexto);
                $('#edtAllow').val(response.data.allow);
                $('#edtWebRTC').val(response.data.webrtc);
                $('#modal-default').modal('show');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function deleteRamal(event) {
    console.log('deleteRamal');
    var id      = $(event).data("id");
    let _url    = 'ramal/delete/'+id;
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

function createRamal() {
    console.log('createRamal');
    var edtId        = $('#edtId').val();
    var edtTransport = $('#edtTransport').val();
    var edtNat       = $('#edtNat').val();
    var edtPassword  = $('#edtPassword').val();
    var edtUsername  = $('#edtUsername').val();
    var edtContexto  = $('#edtContexto').val();
    var edtAllow     = $('#edtAllow').val();
    var edtWebRTC    = $('#edtWebRTC').val();

    let _url     = 'ramal/save';
    let _token   = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: _url,
        type: "POST",
        data: {
            edtId       : edtId,
            edtTransport: edtTransport,
            edtNat      : edtNat,
            edtPassword : edtPassword,
            edtUsername : edtUsername,
            edtContexto : edtContexto,
            edtAllow    : edtAllow,
            edtWebRTC   : edtWebRTC,
            token       : _token
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