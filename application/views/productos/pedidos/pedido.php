<div class="jumbotron">
	<div class="row menuInfoModulo">
		<div class="col-sm-6">
			<h2>Información sobre el pedido</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore quia repudiandae, est placeat.</p>
		</div>
		<div class="col-sm-6 text-right">
			<div class="menuBotones">
				<a href="<?php echo base_url(); ?>admin/productos/pedidos" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Volver</a> 
				<a href="" class="btn btn-sm btn-default">Modificar estado</a>
				<!-- <button type="button" class="btn btn-sm btn-primary" onclick="mostrar_ocultar_modulo('f_producto_nombre')"><i class="fa fa-plus"></i> Nuevo</button> -->
			</div>
		</div>
	</div>
</div>

<div class="row" id="moduloInformacion">
	<div class="col-sm-12">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Productos solicitados</h3>
			</div>
			<table class="table table-striped" id="tabla_pedido_productos"  width="100%">
				<thead>
					<tr>
						<th width="1%"></th>
						<th width="1%"></th>
						<th width="90%">Nombre</th>
						<th width="1%"></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>

	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() 
	{
		// Scripts de Validación
		// var validator = new FormValidator('f_form', [{
		//       name: 'f_nombre',
		//       rules: 'required'
		//   }
		// ], function(errors, event) {
		//       form_error_eliminar("#f_form"); 
		//       if(errors.length > 0) {
		//           //Creando todas las alertas
		//           for (var i=0; i<errors.length; i++) {
		//               var id = errors[i]["id"];
		//               var mensaje = errors[i]["message"];
		//               form_error(id, mensaje);
		//               if(i == 0){ $("#"+id).focus(); }
		//           }
		//       }
		// });

		// Datatable
		tabla = $('#tabla_pedido_productos').DataTable({
			"autoWidth": false,
			"language": {
				"url": base_url+"scripts/script_tablas/spanish.json"
			},
			serverSide: true,
			columns: [
				{ data: 'id', 'visible':false, 'orderable': true, 'searchable': false },
				{ data: 'icono', 'visible':true, 	'orderable': false, 'searchable': false },
				{ data: 'nombre',	'visible':true, 	'orderable': true, 'searchable': true },
				{ data: 'id', 'visible':true, 'searchable':false, 'orderable': false, 'render': function (val, type, row)
          			{
            			var opciones = '<div class="mismalinea">';
						opciones += '<a href="categorias/editar/'+row.id+'" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-pencil"></i></a> ';
            			opciones += '</div>';

			            return opciones;
			    	}
			    }
			],
			order: [
				[ 0, 'asc' ]
			],
			ajax: {
				url: '../lista_pedido_productos',
				type: 'POST',
				data: {
					'f_compra_id': <?php echo $pedido->id; ?>
				}
			}
		});
	});

</script>
