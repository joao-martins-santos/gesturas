
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        {!! Form::label('product_type_id', 'Tipo do Produto:') !!}
        {!! Form::select('product_type_id', $product_type, 0, ['class'=>'form-control select2']) !!}
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
<table id="dataTableRation" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Tintura</th>
            <th>Marca</th>
            <th>Categoria de Ração</th>
        </tr>
    </thead>
    <tbody></tbody>
     <tfoot>
            <th>#</th>
            <th>Nome</th>
            <th>Tintura</th>
            <th>Marca</th>
            <th>Categoria de Ração</th>
            </tr>
        </tfoot>
    </table>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        {!! Form::label('qtd', 'Quantidade:') !!}
        {!! Form::text('qtd', '', ['class' => 'form-control', 'placeholder'=>'Quantidade']) !!}
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        {!! Form::label('price', 'Preço:') !!}
        {!! Form::text('price', '', ['class' => 'form-control',  'placeholder'=>'Preço']) !!}
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        {!! Form::label('description', 'Descrição:') !!}
        {!! Form::textarea('description', '', ['class' => 'form-control','rows'=>'5', 'placeholder'=>'Descrição']) !!}
    </div>
</div>
