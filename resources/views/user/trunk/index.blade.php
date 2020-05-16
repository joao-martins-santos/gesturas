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
        <li class="active">Troncos</li>
    </ol>
</section>
@stop

@section('content')
<br />
<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header"><i class="fa fa-hospital-o"></i> Meus Troncos</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <a class="btn btn-app" data-toggle="modal" data-target="#modal-default">
                <i class="fa fa-plus"></i> Adicionar
            </a>
            <a class="btn btn-app" data-toggle="modal" data-target="#modal-file" onclick="showFile()">
                <i class="fa fa-file-text"></i> Ver Arquivo
            </a>
        </div>
    </div>

    @if( !is_null($trunks_json)>0 )
    <div class="row">
        <div class="box-body">
            <div class="row">
                <div class="box-body">
                    <table id="tbl_consulta">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <!--<th>outbound_auth</th>
                                <th>server_uri</th>
                                <th>client_uri</th>
                                <th>context</th>
                                <th>retry_interval</th>
                                <th>disallow</th>
                                <th>allow</th>
                                <th>aors</th>
                                <th>endpoint</th>
                                <th>match</th>
                                <th>auth_type</th>
                                <th>password</th>
                                <th>username</th>-->
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <!--<th>outbound_auth</th>
                                <th>server_uri</th>
                                <th>client_uri</th>
                                <th>context</th>
                                <th>retry_interval</th>
                                <th>disallow</th>
                                <th>allow</th>
                                <th>aors</th>
                                <th>endpoint</th>
                                <th>match</th>
                                <th>auth_type</th>
                                <th>password</th>
                                <th>username</th>-->
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
            <p>Nenhum Tronco</p>
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
                <h4 class="modal-title">Adicionar Tronco</h4>
            </div>
            <div class="modal-body">
            <form id="trunkForm" name="trunkForm">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" id="edtName" class="form-control">
                </div>

                <div class="form-group">
                  <input type="hidden" name="edtId" id="edtId">
                  <label>Type</label>
                  <select id="edtType" class="form-control">
                    <option value="">Escolha</option>
                    <option value="transport">Transport</option>
                    <option value="registration">Registration</option>
                    <option value="auth">Auth</option>
                    <option value="aor">Aor</option>
                    <option value="endpoint">Endpoint</option>
                    <option value="identify">Identify</option>
                  </select>
                </div>

                <div id="dvTransport" style="display: none">
                    <div class="form-group">
                        <label>Protocol</label>
                        <input type="text" id="edtProtocol" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Bind</label>
                        <input type="text" id="edtBind" class="form-control">
                    </div>
                </div>

                <div id="dvRegistration" style="display: none">
                    <div class="form-group">
                        <label>Outbound Auth</label>
                        <input type="text" id="edtOutboundAuth" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Server Uri</label>
                        <input type="text" id="edtServerUri" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Client Uri</label>
                        <input type="text" id="edtClientUri" class="form-control">
                    </div>
                </div>

                <div id="dvAuth" style="display: none">
                    <div class="form-group">
                        <label>Auth Type</label>
                        <input type="text" id="edtAuthtype" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" id="edtPassword" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" id="edtUsername" class="form-control">
                    </div>
                </div>

                <div id="dvEndpoint" style="display: none">
                    <div class="form-group">
                        <label>Context</label>
                        <input type="text" id="edtContext" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Disallow</label>
                        <input type="text" id="edtDisallow" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Allow</label>
                        <input type="text" id="edtAllow" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Outbound Auth</label>
                        <input type="text" id="edtOutboundAuth2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Aors</label>
                        <input type="text" id="edtAors" class="form-control">
                    </div>
                </div>

                <div id="dvAor" style="display: none">
                    <div class="form-group">
                        <label>Contact</label>
                        <input type="text" id="edtContact" class="form-control">
                    </div>
                </div>

                <div id="dvIdentify" style="display: none">
                    <div class="form-group">
                        <label>Endpoint</label>
                        <input type="text" id="edtEndpoint" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Match</label>
                        <input type="text" id="edtMatch" class="form-control">
                    </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" onclick="createTrunk()" class="btn btn-primary" data-dismiss="modal">Salvar</button>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script>



$("#edtType").change(function() {
    $('#dvIdentify').css('display','none');
    $('#dvTransport').css('display','none');
    $('#dvRegistration').css('display','none');
    $('#dvAuth').css('display','none');
    $('#dvEndpoint').css('display','none');
    $('#dvAor').css('display','none');

    if ( $("#edtType").val() == 'identify'){
        $('#dvIdentify').css('display','block');
      } else if ( $("#edtType").val() == 'transport'){
        $('#dvTransport').css('display','block');
      } else if ( $("#edtType").val() == 'registration'){
        $('#dvRegistration').css('display','block');
      } else if ( $("#edtType").val() == 'auth'){
        $('#dvAuth').css('display','block');
      } else if ( $("#edtType").val() == 'endpoint'){
        $('#dvEndpoint').css('display','block');
      } else if ( $("#edtType").val() == 'aor'){
        $('#dvAor').css('display','block');
      }
  })


function showFile() {
    let _url = 'trunk/showfile';
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

function editTrunk(event) {
    var id   = $(event).data("id");
    let _url = 'trunk/edit/'+id;
    
    $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            console.log(response.data);
            if( response.code == 200 ) {
                $('#edtId').val(response.data.id);
                $('#edtName').val(response.data.name);
                $('#edtType').val(response.data.type);

                $('#edtOutboundAuth').val(response.data.outbound_auth);
                if (response.data.type == 'endpoint'){
                    $('#edtOutboundAuth2').val(response.data.outbound_auth);
                }

                $('#edtServerUri').val(response.data.server_uri);
                $('#edtClientUri').val(response.data.client_uri);
                $('#edtContext').val(response.data.context);
                
                $('#edtDisallow').val(response.data.disallow);
                $('#edtAllow').val(response.data.allow);
                $('#edtAors').val(response.data.aors);
                $('#edtEndpoint').val(response.data.endpoint);
                $('#edtMatch').val(response.data.match);
                $('#edtAuthtype').val(response.data.auth_type);
                $('#edtPassword').val(response.data.password);
                $('#edtUsername').val(response.data.username);

                $('#edtProtocol').val(response.data.protocol);
                $('#edtBind').val(response.data.bind);
                $('#edtContact').val(response.data.contact);

                $('#dvIdentify').css('display','none');
                $('#dvTransport').css('display','none');
                $('#dvRegistration').css('display','none');
                $('#dvAuth').css('display','none');
                $('#dvEndpoint').css('display','none');
                $('#dvAor').css('display','none');

                if ( $("#edtType").val() == 'identify'){
                    $('#dvIdentify').css('display','block');
                } else if ( $("#edtType").val() == 'transport'){
                    $('#dvTransport').css('display','block');
                } else if ( $("#edtType").val() == 'registration'){
                    $('#dvRegistration').css('display','block');
                } else if ( $("#edtType").val() == 'auth'){
                    $('#dvAuth').css('display','block');
                } else if ( $("#edtType").val() == 'endpoint'){
                    $('#dvEndpoint').css('display','block');
                } else if ( $("#edtType").val() == 'aor'){
                    $('#dvAor').css('display','block');
                }

                $('#modal-default').modal('show');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function deleteTrunk(event) {
    console.log('deleteTrunk');
    var id      = $(event).data("id");
    let _url    = 'trunk/delete/'+id;
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

function createTrunk() {
    var edtId           = $('#edtId').val();
    var edtName         = $('#edtName').val();
    var edtType         = $('#edtType').val();
    var edtServerUri    = $('#edtServerUri').val();
    var edtClientUri    = $('#edtClientUri').val();
    var edtContext      = $('#edtContext').val();
    var edtRetryInterval= $('#edtRetryInterval').val();
    var edtDisallow     = $('#edtDisallow').val();
    var edtAllow        = $('#edtAllow').val();
    var edtAors         = $('#edtAors').val();
    var edtEndpoint     = $('#edtEndpoint').val();
    var edtMatch        = $('#edtMatch').val();
    var edtAuthtype     = $('#edtAuthtype').val();
    var edtPassword     = $('#edtPassword').val();
    var edtUsername     = $('#edtUsername').val();

    if (edtType == 'endpoint'){
        var edtOutboundAuth = $('#edtOutboundAuth2').val();
    } else {
        var edtOutboundAuth = $('#edtOutboundAuth').val();
    }
    var edtProtocol     = $('#edtProtocol').val();
    var edtBind         = $('#edtBind').val();
    var edtContact      = $('#edtContact').val();

    console.log($('#edtProtocol').val());
    console.log($('#edtBind').val());

    let _url     = 'trunk/save';
    let _token   = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: _url,
        type: "POST",
        data: {
            edtId           : edtId,
            edtName         : edtName,
            edtType         : edtType,
            edtOutboundAuth : edtOutboundAuth,
            edtServerUri    : edtServerUri,
            edtClientUri    : edtClientUri,
            edtContext      : edtContext,
            edtRetryInterval: edtRetryInterval,
            edtDisallow     : edtDisallow,
            edtAllow        : edtAllow,
            edtAors         : edtAors,
            edtEndpoint     : edtEndpoint,
            edtMatch        : edtMatch,
            edtAuthtype     : edtAuthtype,
            edtPassword     : edtPassword,
            edtUsername     : edtUsername,
            edtProtocol     : edtProtocol,
            edtBind         : edtBind, 
            edtContact      : edtContact,
            token           : _token
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
            //$('#titleError').text(response.responseJSON.errors.title);
            //$('#descriptionError').text(response.responseJSON.errors.description);
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
              "data": <?php echo $trunks_json ?>
            };

$(document).ready(function() {
    $('#tbl_consulta').DataTable(confPTbrDt);
} );

</script>
@stop