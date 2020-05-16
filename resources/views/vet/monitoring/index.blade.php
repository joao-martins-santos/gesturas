@extends('adminlte::page')

@section('title', 'Vet : MAyA')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"/>
<style>
.selected{
   background-color: #8bb07f !important;
}
</style>
@stop

@section('content_header')
<section class="content-header">
    <h1>Pets <small> Autorizados</small></h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Serviços</a></li>
    <li class="active">Acompanhamentos</li>
    </ol>
</section>
@stop


@section('content')

@if( count($pets_assistance)>0 )

<div class="row">
    @foreach($pets_assistance as $pet) 
    <div class="col-md-4">
        <div class="box box-widget widget-user">
            <div class="widget-user-header bg-aqua-active">
                <h3 class="widget-user-username">{{$pet->pet->name}}</h3>
                <h5 class="widget-user-desc">Raça: {{$pet->pet->breed->name}}<br>Sexo: {{$pet->pet->genre}}<br>Idade: {{$pet->pet->timelife}}<br>Tutor: {{$pet->pet->user->name}}</h5>
            </div>
            <!-- 
            <div class="widget-user-image">
              <span class="info-box-icon bg-aqua-active"><i class="fa fa-paw"></i></span>
            </div>
            -->
            <div class="box-footer">
                <div class="row">
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                    <span class="description-text">
                    @if( is_null($pet->pet->cod_collar) )
                        MONITORAR
                    @else
                        <a href="/vet/service/monitoring/details/{{$pet->pet->id}}">MONITORAR</a>
                    @endif
                    </span>
                    </div>
                </div>
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                    <span class="description-text">
                        <a href="/vet/service/monitoring/card/{{$pet->pet->id}}">CARTÃO DE VACINA</a>
                    </span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="description-block">
                    <span class="description-text"><a href="/vet/service/monitoring/history/{{$pet->pet->id}}">HISTÓRICO</a></span>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else

<div class="row">
    <div class="callout callout-warning">
        <h4>Atenção!</h4>
        <p>Nenhum PET autorizado para monitoramento.</p>
    </div>
</div>
@endif

@stop

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script>
(function($){

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
    
    getProduct = function(id){
        return  request = $.ajax({
            url: "{{ url('/shop/product/show')}}" +'/'+id,
            method: 'get'
        });
    };

}(jQuery));
</script>
@stop
