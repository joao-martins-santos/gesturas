@extends('adminlte::page')

@section('title', 'PetShop : MAyA')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"/>
<style>
.selected{
   background-color: #8bb07f !important;
}
</style>
@stop

@section('content_header')
<div class="col-xs-12">
    <h2 class="page-header">
        <i class="fa fa-globe"></i> Produtos
    </h2>
</div>
@stop

@section('content')
<section class="row">
    <div class="col-xs-12">
        <div class="box">
                <div class="box-body">

                <button type="submit" class="btn btn-primary" data-toggle="modal" id="btnadd" data-target="#modalProduct" data-whatever="create" name="btnadd"><i class="fa fa-plus"></i> Cadastar Produto</button>
                    <table id="dataTableProducts" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th>Qtd</th>
                            <th>Tipo do Produto</th>
                            <th style="width: 200px">Ações</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    </table>
                </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    {!! Form::open( [ 'id' => 'formProduct']) !!}
    <div class="modal fade" id="modalProduct" tabindex="-1" role="dialog" aria-labelledby="modalProductLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modalProductLabel">Produto</h4>
            </div>

            <div class="modal-body">
                    <div class="alert alert-danger" style="display:none"></div>

                    <div class="row">
                        @include('shop.product.fields');
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            </div>

            </div>
        </div>
    </div>

    {!! Form::close() !!}

    <div class="modal fade" id="showModalProduct" tabindex="-1" role="dialog" aria-labelledby="showModalProductLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="showModalProductLabel">Detalhes</h4>
        </div>

        <div class="modal-body">
            @include('shop.product.show')
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>

        </div>
    </div>
    </div>


    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirmar Remoção</h4>
                </div>

                <div class="modal-body">
                    Tem certeza que deseja remover esse produto?
                    <p class="debug-url"></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <a class="btn btn-danger btn-ok">Remover</a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script>
(function($){

     var languageTable = {
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
        };

    var tableRation = $('#dataTableRation').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "rowId": 'id',
        "processing": true,
        "ajax": {
            "url": "{{  url('shop/ration')  }}"
        },
        "columns": [
            { "data": null,  "orderable": false },
            { "data": "name" },
            { "data": "dye" },
            { "data": "provider.name" },
            { "data": "ration_category.name" }
        ],
        "sDom": '<"top"if>rt<"bottom"lp><"clear">',
        "language": languageTable,
        initComplete: function () {
            alert()
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }

    });

    $('#dataTableRation tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            tableRation.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    tableRation.on( 'order.dt search.dt', function () {
        tableRation.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    }).draw();

    var table = $('#dataTableProducts').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "rowId": 'id',
        "processing": true,
        "ajax": {
            "url": "{{  url('shop/product/all')  }}"
        },
        "sDom": '<"top"if>rt<"bottom"lp><"clear">',
        "columns": [
            { "data": null,  "orderable": false },
            { "data": "description" },
            { "data": "price" },
            { "data": "qtd" },
            { "data": "product_type.name" },
            {
                mRender: function (data, type, row) {
                    return  '<button class="btn btn-primary" data-toggle="modal" data-target="#showModalProduct" data-id="'+row.id+'"><i class="fa fa-eye"></i></button> ' +
                            ' <button class="btn btn-info" data-toggle="modal" data-target="#modalProduct" data-whatever="edit" data-id="'+row.id+'">Editar</button> ' +
                            ' <button type="submit" class="btn btn-danger" data-id="'+row.id+'" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash"></i></button>'
                }, "orderable": false
            }

        ],
        "language": languageTable
    });

    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    $('#modalProduct').on('show.bs.modal', function (event) {
        button = $(event.relatedTarget);
        recipient = button.data('whatever');
        id = null;
        formSend = $("#formProduct");

        title = {
            create: 'Novo Produto',
            edit: 'Editar Produto'
        };

        modal = $(this);

        if(recipient == 'create')
            resetModal( modal, formSend[0]);
        else{
            id = button.data('id');
            callTosetFields( id );
            resetAlert(modal);
        }

        modal.find('.modal-title').text( title[recipient] );

        formSend.submit( {recipient: recipient, modal: modal, id: id}, submitForm );
    });

    $('#confirm-delete').on('click', '.btn-ok', function(e) {

        $modalDiv = $(e.delegateTarget);
        id = $(this).data('recordId');

        request = destroyProduct(id);

         request.done(function( resp ) {
            if(resp.success){
                $modalDiv.modal('hide').removeClass('loading');
                reloadTable();
            }else
                console.log(resp.errors);
        });

        request.fail(function( jqXHR, textStatus ) {
            console.log(textStatus);
        });
    });

    $('#confirm-delete').on('show.bs.modal', function(e) {
        $data = $(e.relatedTarget).data();

        id = $data.id;

        $('.title', this).text($data.recordTitle);
        $('.btn-ok', this).data('recordId', id);
    });

    $('#showModalProduct').on('show.bs.modal', function (event) {
        button = $(event.relatedTarget);
        id = button.data('id');

        modal = $(this);
        request = getProduct(id);

        request.done(function( resp ) {
            if(resp.success){
                resp = resp.success;

                modal.find('.product_type').text( resp['product_type']['name'] );
                modal.find('.description').text( resp['description'] );
                modal.find('.qtd').text( resp['qtd'] );
                modal.find('.price').text( resp['price'] );

            }else
                console.log(resp.errors);

        });

        request.fail(function( jqXHR, textStatus ) {
            console.log(textStatus);
        });
    });

    reloadTable = function(){
        table.ajax.reload( null, false );
    };

    resetModal = function($modal, $form){
        $form.reset();
        resetAlert($modal);
    };

    resetAlert = function($modal){
        $modal.find('.alert-danger').html('');
    };

    callTosetFields = function(id ){
        request = getProduct( id );

        request.done(function( resp ) {
            resp = resp.success;
            $('#product_type').val( resp['product_type_id'] );
            qtd: $('#qtd').val( resp['qtd'] );
            price: $('#price').val( resp['price'] );
            description: $('#description').val( resp['description'] );

            reloadTable();
        });

        request.fail(function( jqXHR, textStatus ) {
            console.log(textStatus);
        });

    };

    submitForm = function(e){
        e.preventDefault(); // avoid to execute the actual submit of the form.

        method = e.data.recipient == 'create' ? 'post' : 'put';
        modal = e.data.modal;
        id = e.data.id;

        request = sendDatasProduct(method, id);

        request.done(function(resp){
            if(resp.errors){

                alertDanger = modal.find('.alert-danger');

                alertDanger.html('');

                $.each(resp.errors, function(key, value){
                    alertDanger.show();
                    alertDanger.append('<li>'+value+'</li>');
                });

            }else{
                resp = resp.success;
                modal.modal('hide');

                reloadTable();
            }
        });

        request.fail(function(jqXHR, textStatus){
            console.log(jqXHR);
        });

        return false;
    };

    sendDatasProduct = function(method, id = null){
        alert(method);
        return $.ajax({
            url: (method === 'post' ? "{{ url('/shop/product/store') }}" : "{{ url('/shop/product/') }}"  + '/'+id),
            method: method,
            data: {
                _token: '{{csrf_token()}}',
                product_type_id: $('#product_type_id').val(),
                qtd: $('#qtd').val(),
                price: $('#price').val(),
                description: $('#description').val()
            }
        });
    };

    getProduct = function(id){
        return  request = $.ajax({
            url: "{{ url('/shop/product/show')}}" +'/'+id,
            method: 'get'
        });
    };

    destroyProduct = function(id){
        return  request = $.ajax({
            url: "{{ url('/shop/product/')}}" +'/'+id,
            method: 'delete',
            data:{
                _token: '{{csrf_token()}}'
            }
        });
    };

}(jQuery));
</script>
@stop
