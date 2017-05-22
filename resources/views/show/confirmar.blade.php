<div class="col-lg-12">
  <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">productos</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="productos" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Codigo</th>
                    <th>cantidad total</th>
                    <th>reservada</th>
                    <th>disponible</th>
                  </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < $iteracions; $i++)
                    <tr>
                      <td>{{$productos[$i]}}</td>
                      <td>{{$codigos[$i]}}</td>
                      <td>{{$total[$i]}}</td>
                      <td>{{$reservada[$i]}}</td>
                      @if($total[$i]-$reservada[$i]>0)
                      <td class="alert alert-success">{{$total[$i]-$reservada[$i]}}</td>
                      @else
                    <td class="alert alert-danger">{{$total[$i]-$reservada[$i]}}</td>
                      @endif


                      </tr>
@endfor
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Nombre</th>
                    <th>Codigo</th>
                    <th>cantidad total</th>
                    <th>reservada</th>
                    <th>disponible</th>
                   </tr>
                   </tfoot>
                   </table>
                 </div>
                 </div>
               </div>


               <script type="text/javascript">
               $(function () {
               	$("#productos").DataTable({
               		"language": {
               					"lengthMenu": "Mostrar _MENU_ productos por pagina",
               					"zeroRecords": "No hay productos registrados",
               					"info": "Pagina _PAGE_ de _PAGES_",
               					"infoEmpty": "Ninguna bodega encontrada",
               					"infoFiltered": "(Filtrado de _MAX_ bodegas )",
               					"search":         "Buscar:",
               					"paginate": {
               			"first":      "Primero",
               			"last":       "Ultimo",
               			"next":       "Siguiente",
               			"previous":   "Anterior"
               	}
               			}
               	});
               });

               </script>
