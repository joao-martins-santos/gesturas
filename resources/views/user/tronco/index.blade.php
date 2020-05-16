@extends('adminlte::page')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://codeseven.github.io/toastr/build/toastr.min.css"/>

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
        <li class="active">Tronco</li>
    </ol>
</section>
@stop

@section('content')
<br />
<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header"><i class="fa fa-hospital-o"></i> Meus Tronco</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <a class="btn btn-app" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Adicionar</a>
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
                                <th>Tronco</th>
                                <th>Transport</th>
                                <th>Context</th>
                                <th>Codecs</th>
                                <th>Line Method</th>
                                <th>Client URI</th>
                                <th>Server URI</th>
                                <th>NAT</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tronco</th>
                                <th>Transport</th>
                                <th>Context</th>
                                <th>Codecs</th>
                                <th>Line Method</th>
                                <th>Client URI</th>
                                <th>Server URI</th>
                                <th>NAT</th>
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
            <p>Nenhum Tronco casdastrado</p>
        </div>
    </div>
    @endif
</section>


<div class="modal fade" id="modal-show">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detalhes Tronco</h4>
            </div>
            <div class="modal-body" id="divShow">
                
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
                <h4 class="modal-title">Adicionar Tronco</h4>
            </div>
            <div class="modal-body">
            <form id="troncoForm" name="troncoForm">

                <div class="form-group">
                    <label>Tronco</label>
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
                    <label>Contact</label>
                    <input type="text" id="edtContact" class="form-control" value="teste-dtm">
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
                    <label>Context</label>
                    <input type="text" id="edtContext" class="form-control" value="teste-dtm">
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
                    <label>Line Method</label>
                    <select id="edtLineMethod" class="form-control">
                        <option value="">Escolher</option>
                        <option value="invite">invite</option>
                        <option value="reinvite">reinvite</option>
                        <option value="update">update</option>
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

                <div class="form-group">
                    <label>Password</label>
                    <input type="text" id="edtPassword" class="form-control">
                </div>

            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" onclick="createTronco()" class="btn btn-primary" data-dismiss="modal">Salvar</button>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" src="https://codeseven.github.io/toastr/build/toastr.min.js"></script>
<script type="text/javascript" src="https://codeseven.github.io/toastr/glimpse.js"></script>
<script type="text/javascript" src="https://codeseven.github.io/toastr/glimpse.toastr.js"></script>

<script>

    toastr.options = {
            "closeButton"   : false,
            "debug"         : false,
            "newestOnTop"   : false,
            "progressBar"   : true,
            "positionClass" : "toast-top-center",
            "preventDuplicates" : false,
            "onclick"       : null,
            "showDuration"  : "300",
            "hideDuration"  : "1000",
            "timeOut"       : "5000",
            "extendedTimeOut" : "1000",
            "showEasing"    : "swing",
            "hideEasing"    : "linear",
            "showMethod"    : "fadeIn",
            "hideMethod"    : "fadeOut"
        };

// toastr["success"]("I do not think that means what you think it means.");
// toastr["error"]("I do not think that means what you think it means.");
// toastr["info"]("I do not think that means what you think it means.");

$("#edtId").change(function() {
    let _url = 'tronco/validator/'+$("#edtId").val();
    $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            console.log(response.message);
            if( response.message ) {
                toastr["info"](response.message);
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
})

function showTronco(id) {
    //var id   = $(event).data("id");
    let _url = 'tronco/show/'+id;

    console.log('AAAAAAAAAA');
    console.log(id);

    $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            //console.log(response);
            console.log(response.data[0]);

            if( response.code == 200 ) {
                var conteudo  = "<table>";
                conteudo += "<tr><th>Tronco</th><td>: "+response.data[0].id+"</td></tr>";
                conteudo += "<tr><th>transport</th><td>: "+response.data[0].transport+"</td></tr>";
                conteudo += "<tr><th>context</th><td>: "+response.data[0].context+"</td></tr>";
                conteudo += "<tr><th>allow</th><td>: "+response.data[0].allow+"</td></tr>";
                conteudo += "<tr><th>connected_line_method</th><td>: "+response.data[0].connected_line_method+"</td></tr>";
                conteudo += "<tr><th>disallow</th><td>: "+response.data[0].disallow+"</td></tr>";
                conteudo += "<tr><th>direct_media</th><td>"+response.data[0].direct_media+"</td></tr>";
                conteudo += "<tr><th>force_rport</th><td>"+response.data[0].force_rport+"</td></tr>";
                conteudo += "<tr><th>rewrite_contact</th><td>"+response.data[0].rewrite_contact+"</td></tr>";
                conteudo += "<tr><th>rtp_symmetric</th><td>"+response.data[0].rtp_symmetric+"</td></tr>";
                conteudo += "<tr><th>timers_sess_expires</th><td>"+response.data[0].timers_sess_expires+"</td></tr>";
                conteudo += "<tr><th>password</th><td>"+response.data[0].password+"</td></tr>";
                conteudo += "<tr><th>username</th><td>"+response.data[0].username+"</td></tr>";
                conteudo += "<tr><th>auth_type</th><td>"+response.data[0].auth_type+"</td></tr>";
                conteudo += "<tr><th>max_contacts</th><td>"+response.data[0].max_contacts+"</td></tr>";
                conteudo += "<tr><th>default_expiration</th><td>"+response.data[0].default_expiration+"</td></tr>";
                conteudo += "<tr><th>minimum_expiration</th><td>"+response.data[0].minimum_expiration+"</td></tr>";
                conteudo += "<tr><th>remove_existing</th><td>"+response.data[0].remove_existing+"</td></tr>";
                conteudo += "<tr><th>qualify_frequency</th><td>"+response.data[0].qualify_frequency+"</td></tr>";
                conteudo += "<tr><th>authenticate_qualify</th><td>"+response.data[0].authenticate_qualify+"</td></tr>";
                conteudo += "<tr><th>maximum_expiration</th><td>"+response.data[0].maximum_expiration+"</td></tr>";
                conteudo += "<tr><th>client_uri</th><td>"+response.data[0].client_uri+"</td></tr>";
                conteudo += "<tr><th>server_uri</th><td>"+response.data[0].server_uri+"</td></tr>";
                conteudo += "<tr><th>contact_user</th><td>"+response.data[0].contact_user+"</td></tr>";
                conteudo += "<tr><th>expiration</th><td>"+response.data[0].expiration+"</td></tr>";
                conteudo += "<tr><th>retry_interval</th><td>"+response.data[0].retry_interval+"</td></tr>";
                conteudo += "<tr><th>forbidden_retry_interval</th><td>"+response.data[0].forbidden_retry_interval+"</td></tr>";
                conteudo += "<tr><th>match</th><td>"+response.data[0].match+"</td></tr>";
                conteudo += "</table>";

                $('#divShow').append(conteudo);
                $('#modal-show').modal('show');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function editTronco(event) {
    var id   = $(event).data("id");
    let _url = 'tronco/edit/'+id;
    
    $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            console.log('retorno');
            if( response.code == 200 ) {
                $('#edtId').val(response.data[0].id);
                $('#edtContact').val(response.data[0].contact);
                $('#edtPassword').val(response.data[0].password);
                $('#edtTransport').val(response.data[0].transport);
                $('#edtContext').val(response.data[0].context);
                $('#edtAllow').val(response.data[0].allow);
                $('#edtLineMethod').val(response.data[0].connected_line_method);
                $('#edtClientUri').val(response.data[0].client_uri);
                $('#edtServerUri').val(response.data[0].server_uri);

                if ( response.data[0].force_rport == 'yes' && response.data[0].rewrite_contact  == 'yes' && response.data[0].rtp_symmetric == 'yes' ){
                    $('#edtNat').val('S');
                } else if ( response.data[0].force_rport == 'no' && response.data[0].rewrite_contact  == 'no' && response.data[0].rtp_symmetric == 'no' ){
                    $('#edtNat').val('N');
                } else if ( response.data[0].force_rport == 'yes' && response.data[0].rewrite_contact  == 'yes' && response.data[0].rtp_symmetric == 'no' ){
                    $('#edtNat').val('R');
                }

                $('#modal-default').modal('show');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function deleteTronco(event) {
    console.log('deleteTronco');
    var id      = $(event).data("id");
    let _url    = 'tronco/delete/'+id;
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

function createTronco() {

    console.log($('#edtId').val());
    var edtId         = $('#edtId').val();
    var edtTransport  = $('#edtTransport').val();
    var edtContact    = $('#edtContact').val();
    var edtNat        = $('#edtNat').val();
    var edtContext    = $('#edtContext').val();
    var edtAllow      = $('#edtAllow').val();
    var edtLineMethod = $('#edtLineMethod').val();
    var edtClientUri  = $('#edtClientUri').val();
    var edtServerUri  = $('#edtServerUri').val();
    var edtPassword   = $('#edtPassword').val();
    let _url          = 'tronco/save';
    let _token        = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: _url,
        type: "POST",
        data: {
            edtId         : edtId,
            edtTransport  : edtTransport,
            edtContact    : edtContact,
            edtNat        : edtNat,
            edtContext    : edtContext,
            edtAllow      : edtAllow,
            edtLineMethod : edtLineMethod,
            edtClientUri  : edtClientUri,
            edtServerUri  : edtServerUri,
            edtPassword   : edtPassword,
            token         : _token
        },
        success: function(response) {
            console.log(response);
            if(response.code == 200) {
                toastr["success"](response.message);
                $('#post-modal').modal('hide');
                location.reload();
            }
        },
        error: function(response) {
            toastr["error"](response.message);
            console.log('ccccccc');
        }
    });
}

$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
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