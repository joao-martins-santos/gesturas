

   <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Hover Data Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="lista-permissoes" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Ação</th>
                  <th>Nome</th>
                  <th>Descrição</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($permissao as $permissao)
                <tr>
                  <form action="#" method="post">                   <td>
                        <a href="/permissao/{{$permissao->id}}/edit" title="Editar registro" class="btn btn-warning glyphicon glyphicon-pencil"></a>
                      {{ method_field('DELETE') }}
                      {{ csrf_field() }}
                      <button type="submit" class="btn btn-danger glyphicon glyphicon-remove " title="Excluir registro"></button>
                    </td>
                    <td>{{ $permissao->nome }}</td>
                    <td>{{ $permissao->descricao }}</td>
                  </form>
                </tr>
                @endforeach
                
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
            </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
<!-- jQuery 2.2.3 -->
<script src="{{base_path('public/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{base_path('public/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- DataTables -->
<script src="{{base_path('public/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{base_path('public/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{base_path('public/bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{base_path('public/bower_components/AdminLTE/plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{base_path('public/bower_components/AdminLTE/dist/js/app.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{base_path('public/bower_components/AdminLTE/dist/js/demo.js')}}"></script>
<!-- page script -->
<script>
$(function () {
    $('#example').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
        


