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
        <li class="active">Endpoint</li>
    </ol>
</section>
@stop

@section('content')
<br />
<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header"><i class="fa fa-hospital-o"></i> Meus Endpoints</h2>
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
                                <th>Aors</th>
                                <th>Auth</th>
                                <th>Context</th>
                                <th>Disallow</th>
                                <th>Allow</th>
                                <th>Direct Media</th>
                                <th>Force Report</th>
                                <th>Rewrite Contact</th>
                                <th>RTP Symmetric</th>
                                <th>Timers Expires</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Transport</th>
                                <th>Aors</th>
                                <th>Auth</th>
                                <th>Context</th>
                                <th>Disallow</th>
                                <th>Allow</th>
                                <th>Direct Media</th>
                                <th>Force Report</th>
                                <th>Rewrite Contact</th>
                                <th>RTP Symmetric</th>
                                <th>Timers Expires</th>
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
            <p>Nenhum Endpoint</p>
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
                <h4 class="modal-title">Adicionar Endpoint</h4>
            </div>
            <div class="modal-body">
                <form id="endForm" name="endForm">
                    <div class="form-group">
                        <label>NAT</label>
                        <select id="edtNat" class="form-control">
                            <option value="S">Sim</option>
                            <option value="N">Não</option>
                            <option value="R">Roteado</option>
                        </select>
                    </div>
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
                        <label>Aors</label>
                        <input type="text" id="edtAors" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Auth</label>
                        <input type="text" id="edtAuth" class="form-control">
                    </div>
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
                        <label>Direct Media</label>
                        <select id="edtDirectMedia" class="form-control">
                            <option value="yes">Sim</option>
                            <option value="no">Não</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Timers Expires</label>
                        <input type="text" id="edtTimersExpires" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" onclick="createEnd()" class="btn btn-primary" data-dismiss="modal">Salvar</button>
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

function editEnd(event) {
    var id   = $(event).data("id");
    let _url = 'endpoint/edit/'+id;
    $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            console.log(response.data);
            if( response.code == 200 ) {
                $('#edtId').val(response.data.id);
                $('#edtId').prop('readonly', true);
                $('#edtTransport').val(response.data.transport);
                $('#edtAors').val(response.data.aors);
                $('#edtAuth').val(response.data.auth);
                $('#edtContext').val(response.data.context);
                $('#edtDisallow').val(response.data.disallow);
                $('#edtAllow').val(response.data.allow);
                $('#edtDirectMedia').val(response.data.direct_media);
                /*$('#edtForceRport').val(response.data.force_rport);
                $('#edtRewriteContact').val(response.data.rewrite_contact);
                $('#edtRtpSymmetric').val(response.data.rtp_symmetric);*/
                $('#edtTimersExpires').val(response.data.timers_sess_expires);

                if ( response.data.force_rport =='yes' && response.data.rewrite_contact == 'yes' && response.data.rtp_symmetric == 'yes' ){
                    $('#edtNat option[value="S"]').attr("selected", "selected");
                } else if ( response.data.force_rport =='no' && response.data.rewrite_contact == 'no' && response.data.rtp_symmetric == 'no' ){
                    $('#edtNat option[value="N"]').attr("selected", "selected");
                } else{
                    $('#edtNat option[value="R"]').attr("selected", "selected");
                }

                $('#modal-default').modal('show');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function deleteEnd(event) {
    console.log('deleteEnd');
    var id      = $(event).data("id");
    let _url    = 'endpoint/delete/'+id;
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
    var edtTypeNat              = $('#edtId').val();
    var edttransport            = $('#edtTransport').val();
    var edtaors                 = $('#aors').val();
    var edtauth                 = $('#auth').val();
    var edtcontext              = $('#context').val();
    var edtdisallow             = $('#disallow').val();
    var edtallow                = $('#allow').val();
    var edtdirect_media         = $('#edtDirectMedia').val();
    var edtforce_rport          = $('#edtForceReport').val();
    var edtrewrite_contact      = $('#edtRewriteContact').val();
    var edtrtp_symmetric        = $('#edtRtpSymmetric').val();
    var edttimers_sess_expires  = $('#edtTimersExpires').val();
    
    var edtRtpSymmetric     = '';
    var edtRewriteContact   = '';
    var edtForceRport       = '';

    switch ($('#edtNat').val()) {
        case 'S':
            edtRtpSymmetric     = 'yes';
            edtRewriteContact   = 'yes';
            edtForceRport       = 'yes';
        break;
        case 'N':
            edtRtpSymmetric     = 'no';
            edtRewriteContact   = 'no';
            edtForceRport       = 'no';
        break;
        case 'R':
            edtRtpSymmetric     = 'no';
            edtRewriteContact   = 'yes';
            edtForceRport       = 'yes';
        break;
    }


    let _url     = 'endpoint/save';
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
              "data": <?php echo $dados_json ?>
            };

$(document).ready(function() {
    $('#tbl_consulta').DataTable(confPTbrDt);
} );

</script>
@stop