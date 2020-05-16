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

    @if( !is_null($branchs_json)>0 )
    <div class="row">
        <div class="box-body">
            <div class="row">
                <div class="box-body">
                    <table id="tbl_consulta">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
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
                    <option value="auth">Auth</option>
                    <option value="aor">Aor</option>
                    <option value="endpoint">Endpoint</option>
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
                        <label>Aors</label>
                        <input type="text" id="edtAors" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Auth</label>
                        <input type="text" id="edtAuth" class="form-control">
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
    $('#dvTransport').css('display','none');
    $('#dvAuth').css('display','none');
    $('#dvEndpoint').css('display','none');
    $('#dvAor').css('display','none');

    if ( $("#edtType").val() == 'transport'){
        $('#dvTransport').css('display','block');
    } else if ( $("#edtType").val() == 'auth'){
        $('#dvAuth').css('display','block');
    } else if ( $("#edtType").val() == 'endpoint'){
        $('#dvEndpoint').css('display','block');
    } else if ( $("#edtType").val() == 'aor'){
        $('#dvAor').css('display','block');
    }

})

function showFile() {
    let _url = 'branch/showfile';
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

function editBranch(event) {
    var id   = $(event).data("id");
    let _url = 'branch/edit/'+id;
    
    $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            console.log(response.data);
            if( response.code == 200 ) {
                $('#edtId').val(response.data.id);
                $('#edtName').val(response.data.name);
                $('#edtType').val(response.data.type);

                $('#edtProtocol').val(response.data.protocol);
                $('#edtBind').val(response.data.bind);
                $('#edtContext').val(response.data.context);
                $('#edtDisallow').val(response.data.disallow);
                $('#edtAllow').val(response.data.allow);
                $('#edtAors').val(response.data.aors);
                $('#edtAuth').val(response.data.auth);
                $('#edtMaxContacts').val(response.data.max_contacts);
                $('#edtAuthtype').val(response.data.auth_type);
                $('#edtPassword').val(response.data.password);
                $('#edtUsername').val(response.data.username);
                $('#edtContact').val(response.data.contact);
               
                $('#dvTransport').css('display','none');
                $('#dvEndpoint').css('display','none');
                $('#dvAor').css('display','none');
                $('#dvAuth').css('display','none');

                if ( $("#edtType").val() == 'transport'){
                    $('#dvTransport').css('display','block');
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

function deleteBranch(event) {
    console.log('deleteBranch');
    var id      = $(event).data("id");
    let _url    = 'branch/delete/'+id;
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

function createBranch() {
    var edtId           = $('#edtId').val();
    var edtName         = $('#edtName').val();
    var edtType         = $('#edtType').val();
    var edtProtocol     = $('#edtProtocol').val();
    var edtBind         = $('#edtBind').val();
    var edtContext      = $('#edtContext').val();
    var edtDisallow     = $('#edtDisallow').val();
    var edtAllow        = $('#edtAllow').val();
    var edtAors         = $('#edtAors').val();
    var edtAuth         = $('#edtAuth').val();
    var edtMaxContacts  = $('#edtMaxContacts').val();
    var edtAuthType     = $('#edtAuthType').val();
    var edtPassword     = $('#edtPassword').val();
    var edtUsername     = $('#edtUsername').val();
    var edtContact      = $('#edtContact').val();

    let _url     = 'branch/save';
    let _token   = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: _url,
        type: "POST",
        data: {
            edtId       : edtId,
            edtName     : edtName,
            edtType     : edtType,
            edtProtocol : edtProtocol,
            edtBind     : edtBind, 
            edtContext  : edtContext,
            edtDisallow : edtDisallow,
            edtAllow    : edtAllow,
            edtAors     : edtAors,
            edtAuth     : edtAuth,
            edtMaxContacts  : edtMaxContacts,
            edtAuthType     : edtAuthType,
            edtPassword     : edtPassword,
            edtUsername     : edtUsername,
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
              "data": <?php echo $branchs_json ?>
            };

$(document).ready(function() {
    $('#tbl_consulta').DataTable(confPTbrDt);
} );

</script>
@stop