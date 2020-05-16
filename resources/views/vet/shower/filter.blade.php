<!DOCTYPE html>

<html lang="en">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Laravel DataTable With Custom Filter - Tuts Make</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
</head>
<body>
    
 <div class="container">
   <h2>Laravel DataTable With Custom Filter - Tuts Make</h2>
   <br>
   <div class="row">
    <div class="form-group col-md-6">
    <h5>Start Date <span class="text-danger"></span></h5>
    <div class="controls">
        <input type="date" name="start_date" id="start_date" class="form-control datepicker-autoclose" placeholder="Please select start date"> <div class="help-block"></div></div>
    </div>
    <div class="form-group col-md-6">
    <h5>End Date <span class="text-danger"></span></h5>
    <div class="controls">
        <input type="date" name="end_date" id="end_date" class="form-control datepicker-autoclose" placeholder="Please select end date"> <div class="help-block"></div></div>
    </div>
    <div class="text-left" style="
    margin-left: 15px;
    ">
    <button type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>
    </div>
    </div>
    <br>
    <table class="table table-bordered" id="laravel_datatable">
       <thead>
          <tr>
             <th>Id</th>
             <th>Name</th>
             <th>Email</th>
             <th>Created at</th>
          </tr>
       </thead>
    </table>

    <hr>

    <div class="row">
            <div class="col-xs-6">
              <div class="form-group">
                <label>Código Pet</label>
                <div class="input-group col-xs-4">
                    <input type="text" class="form-control" id="codigo" >
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" id="btnGo">Go!</button>
                    </span>
                </div>
              </div>
            </div>
          </div>

        <div class="row invoice-info">
                <div class="col-sm-4 invoice-col" id="dadosPetDiv">
                    <address id='dadosPet'>
                        <strong>Dados do Pet</strong><br>
                        <b>Nome:</b>&nbsp;<br>
                        <b>Idade:</b>&nbsp;<br>
                        <b>Sexo:</b>&nbsp;<br>
                        <b>Peso:</b>&nbsp;<br>
                    </address>
                </div>
            
                <div class="col-sm-4 invoice-col" id="dadosTutorDiv">
                    <address id='dadosTutor'>
                        <strong>Dados do Tutor</strong><br>
                        <b>Nome:</b>&nbsp;<br>
                        <b>CPF:</b>&nbsp;<br>
                        <b>Data de Nascimento:</b>&nbsp;<br>
                        <b>E-mail:</b>&nbsp;<br>
                    </address>
                </div>

                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong>Dados do Veterinário</strong><br>
                        <b>Nome:</b> Dra. Aline Martins<br>
                        <b>CRMV:</b> XYZ000<br>
                        <b>Especialidade:</b> Clinico Geral, Cirurgião, Dermatologista
                    </address>
                </div>
            </div>


 </div>

 <script>
 $(document).ready( function () {
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

  $('#laravel_datatable').DataTable({
         processing: true,
         serverSide: true,
         ajax: {
          url: "{{ url('vet/service/consult/users-list') }}",
          type: 'GET',
          data: function (d) {
          d.start_date = $('#start_date').val();
          d.end_date = $('#end_date').val();
          }
         },
         columns: [
                  { data: 'id', name: 'id' },
                  { data: 'name', name: 'name' },
                  { data: 'email', name: 'email' },
                  { data: 'birtdate', name: 'birtdate' }
               ]
      });
  

    $('#btnFiterSubmitSearch').click(function(){
        $('#laravel_datatable').DataTable().draw(true);
    });

/*
    $('#btnGo').click(function(){
        $('#laravel2_datatable2').DataTable().draw(true);
    });

<div class="col-sm-4 invoice-col">
                    <address name='dadosPET'>
                        <b>Nome:</b>&nbsp;<br>
                        <b>Idade:</b>&nbsp;<br>
                        <b>Sexo:</b>&nbsp;<br>
                        <b>Peso:</b>&nbsp;<br>
                    </address>
                </div>
            
                <div class="col-sm-4 invoice-col">
                    <address name='dadosTutor'>
                        <strong>Dados do Tutor</strong><br>
                        <b>Nome:</b>&nbsp;<br>
                        <b>CPF:</b>&nbsp;<br>
                        <b>Data de Nascimento:</b>&nbsp;<br>
                        <b>E-mail:</b>&nbsp;<br>
                    </address>
                </div>

                "+ $('#codigo').val() +"

*/

    $('#btnGo').click(function(){
        var num = $('#codigo').val();
        $.ajax({
            method: 'GET',
            url: '/vet/service/consult/pet-user-cod/' + num,
            success: function (data) {
                var html =  '<address id="dadosPet">' +
                            '<strong>Dados do Pet</strong><br>'+
                            '<b>Nome: </b>' + data.namePET + '<br>' +
                            '<b>Idade: </b>' + data.timelifePET + '<br>' +
                            '<b>Sexo: </b>' + data.genrePET + '<br>' +
                            '<b>Peso: </b>' + data.weightPET + '<br>' +
                            '</address>';
                $('#dadosPet').remove();
                $('#dadosPetDiv').append(html);
         
                var html =  '<address id="dadosTutor">' +
                            '<strong>Dados do Tutor</strong><br>'+
                            '<b>Nome: </b>' + data.nameUser + '<br>' +
                            '<b>CPF: </b>' + data.cpfUser + '<br>' +
                            '<b>Data de Nascimento: </b>' + data.birtdateUser + '<br>' +
                            '<b>E-mail: </b>' + data.emailUser + '<br>' +
                            '</address>';
                $('#dadosTutor').remove();
                $('#dadosTutorDiv').append(html);
            },
            error: function (data) {
            }
        });
    }); 

   });


</script>
</body>
</html>