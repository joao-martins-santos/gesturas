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
        <li class="active">Transporte</li>
    </ol>
</section>
@stop

@section('content')
<br />
<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header"><i class="fa fa-hospital-o"></i> Meus Transportes</h2>
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

    @if( !is_null($trans_json)>0 )
    <div class="row">
        <div class="box-body">
            <div class="row">
                <div class="box-body">
                    <table id="tbl_consulta">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Bind</th>
                                <th>Protocol</th>
                                <th>Metódo</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Bind</th>
                                <th>Protocol</th>
                                <th>Metódo</th>
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
                <h4 class="modal-title">Adicionar Transporte</h4>
            </div>
            <div class="modal-body">
            <form id="trunkForm" name="trunkForm">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" id="edtId" class="form-control">
                </div>

                <div class="form-group">
                  <label>Protocol</label>
                  <select id="edtProtocol" class="form-control">
                    <option value="">Escolha</option>
                    <option value="udp">udp</option>
                    <option value="tcp">tcp</option>
                    <option value="tls">tls</option>
                    <option value="ws">ws</option>
                    <option value="wss">wss</option>
                  </select>
                </div>

                <div class="form-group">
                    <label>Bind</label>
                    <input type="text" id="edtBind" class="form-control">
                </div>

                <div class="form-group">
                  <label>Metódo</label>
                  <select id="edtMethod" class="form-control">
                    <option value="">Escolha</option>
                    <option value="default">default</option>
                    <option value="unspecified">unspecified</option>
                    <option value="tlsv1">tlsv1</option>
                    <option value="sslv2">sslv2</option>
                    <option value="sslv3">sslv23</option>
                  </select>
                </div>

            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" onclick="createTransport()" class="btn btn-primary" data-dismiss="modal">Salvar</button>
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
    let _url = 'transport/showfile';
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

function editTransport(event) {
    var id   = $(event).data("id");
    let _url = 'transport/edit/'+id;
    
    $.ajax({
        url: _url,
        type: "GET",
        success: function(response) {
            console.log(response.data);
            if( response.code == 200 ) {
                $('#edtId').val(response.data.id);
                $('#edtMethod').val(response.data.method);
                $('#edtProtocol').val(response.data.protocol);
                $('#edtBind').val(response.data.bind);
                $('#modal-default').modal('show');
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function deleteTransport(event) {
    console.log('deletetransport');
    var id      = $(event).data("id");
    let _url    = 'transport/delete/'+id;
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

function createTransport() {
    var edtId           = $('#edtId').val();
    var edtType         = $('#edtType').val();
    var edtProtocol     = $('#edtProtocol').val();
    var edtBind         = $('#edtBind').val();
    var edtMethod       = $('#edtMethod').val();
    let _url            = 'transport/save';
    let _token          = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: _url,
        type: "POST",
        data: {
            edtId       : edtId,
            edtType     : edtType,
            edtProtocol : edtProtocol,
            edtBind     : edtBind, 
            edtMethod   : edtMethod,
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
              "data": <?php echo $trans_json ?>
            };

$(document).ready(function() {
    $('#tbl_consulta').DataTable(confPTbrDt);
} );

</script>
@stop