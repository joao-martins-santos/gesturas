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
        <li class="active">Aor</li>
    </ol>
</section>
@stop

@section('content')
<br />
<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header"><i class="fa fa-hospital-o"></i> Meus Aors</h2>
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

    @if( !is_null($aors_json)>0 )
    <div class="row">
        <div class="box-body">
            <div class="row">
                <div class="box-body">
                    <table id="tbl_consulta">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Default Expiration</th>
                                <th>Max Contacts</th>
                                <th>Minimum Expiration</th>
                                <th>Remove Existing</th>
                                <th>Qualify Frequency</th>
                                <th>Authenticate Qualify</th>
                                <th>Maximum Expiration</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Default Expiration</th>
                                <th>Max Contacts</th>
                                <th>Minimum Expiration</th>
                                <th>Remove Existing</th>
                                <th>Qualify Frequency</th>
                                <th>Authenticate Qualify</th>
                                <th>Maximum Expiration</th>
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
            <p>Nenhum Aor</p>
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
                <h4 class="modal-title">Adicionar Aor</h4>
            </div>
            <div class="modal-body">
            <form id="aorForm" name="aorForm">
                <div class="form-group">
                    <label>Id</label>
                    <input type="text" id="edtId" class="form-control">
                </div>
                <div class="form-group">
                    <label>Default Expiration</label>
                    <input type="text" id="edtDefaultExpiration" class="form-control">
                </div>
                <div class="form-group">
                    <label>Max Contacts</label>
                    <input type="text" id="edtMaxContacts" class="form-control">
                </div>
                <div class="form-group">
                    <label>Minimum Expiration</label>
                    <input type="text" id="edtMinimumExpiration" class="form-control">
                </div>
                <div class="form-group">
                    <label>Remove Existing</label>
                    <select id="edtRemoveExisting" class="form-control">
                        <option value="">Escolha</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Qualify Frequency</label>
                    <input type="text" id="edtQualifyFrequency" class="form-control">
                </div>
                <div class="form-group">
                    <label>Authenticate Qualify</label>
                    <select id="edtAuthenticateQualify" class="form-control">
                        <option value="">Escolha</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Maximum Expiration</label>
                    <input type="text" id="edtMaximumExpiration" class="form-control">
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" onclick="createAor()" class="btn btn-primary" data-dismiss="modal">Salvar</button>
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
    let _url = 'aor/showfile';
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

function editAor(event) {
    var id   = $(event).data("id");
    let _url = 'aor/edit/'+id;
    
    $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            console.log(response.data);
            if( response.code == 200 ) {
                $('#edtId').val(response.data.id);
                $('#edtId').prop('readonly', true);
                $('#edtDefaultExpiration').val(response.data.default_expiration);
                $('#edtMaxContacts').val(response.data.max_contacts);
                $('#edtMinimumExpiration').val(response.data.minimum_expiration);
                $('#edtRemoveExisting').val(response.data.remove_existing);
                $('#edtQualifyFrequency').val(response.data.qualify_frequency);
                $('#edtAuthenticateQualify').val(response.data.authenticate_qualify);
                $('#edtMaximumExpiration').val(response.data.maximum_expiration);
                $('#modal-default').modal('show');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function deleteAor(event) {
    console.log('deleteTrunk');
    var id      = $(event).data("id");
    let _url    = 'aor/delete/'+id;
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
    var edtId                   = $('#edtId').val();
    var edtDefaultExpiration    = $('#edtDefaultExpiration').val();
    var edtMaxContacts		    = $('#edtMaxContacts').val();
    var edtMinimumExpiration    = $('#edtMinimumExpiration').val();
    var edtRemoveExisting	    = $('#edtRemoveExisting').val();
    var edtQualifyFrequency	    = $('#edtQualifyFrequency').val();
    var edtAuthenticateQualify  = $('#edtAuthenticateQualify').val();
    var edtMaximumExpiration    = $('#edtMaximumExpiration').val();

    let _url     = 'aor/save';
    let _token   = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: _url,
        type: "POST",
        data: {
            edtId                   : edtId,
            edtDefaultExpiration    : edtDefaultExpiration,
            edtMaxContacts		    : edtMaxContacts,
            edtMinimumExpiration    : edtMinimumExpiration,
            edtRemoveExisting	    : edtRemoveExisting,
            edtQualifyFrequency	    : edtQualifyFrequency,
            edtAuthenticateQualify  : edtAuthenticateQualify,
            edtMaximumExpiration    : edtMaximumExpiration,
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
              "data": <?php echo $aors_json ?>
            };

$(document).ready(function() {
    $('#tbl_consulta').DataTable(confPTbrDt);
} );

</script>
@stop