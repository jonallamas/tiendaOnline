<div class="row menuInfoModulo">
	<div class="col-sm-6">
		<h2>Administración de productos</h2>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore quia repudiandae, est placeat.</p>
	</div>
	<div class="col-sm-6 text-right">
		<div class="menuBotones">
			<a href="<?php echo base_url(); ?>productos/categorias" class="btn btn-sm btn-default">Categorías</a> 
			<button type="button" class="btn btn-sm btn-primary" onclick="mostrar_ocultar_modulo('f_producto_nombre')"><i class="fa fa-plus"></i> Nuevo</button>
		</div>
	</div>
</div>

<br>

<div class="row" id="moduloCarga" style="display: none;">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Nuevo producto</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<div class="col-sm-8">
						<label for="f_producto_nombre">Nombre</label>
						<input type="text" name="f_producto_nombre" id="f_producto_nombre" class="form-control">
					</div>
					<div class="col-sm-4">
						<label for="f_producto_categoria">Categoría</label>
						<select name="f_producto_categoria" id="f_producto_categoria" class="form-control">
							<option value="">Seleccione una opción</option>
							<?php foreach ($categorias as $categoria) { ?>
							<option value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="panel-footer text-right">
				<button type="button" class="btn btn-sm btn-default" onclick="mostrar_ocultar_modulo()">Cancelar</button>
				<button type="button" class="btn btn-sm btn-primary">Guardar</button>
			</div>
		</div>
	</div>
</div>

<div class="row" id="moduloInformacion">
	<div class="col-sm-12">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Lista productos</h3>
			</div>
			<table class="table table-striped" id="tabla_productos"  width="100%">
				<thead>
					<tr>
						<th width="1%"></th>
						<th width="1%"></th>
						<th width="90%">Nombre</th>
						<th width="1%">Categoría</th>
						<th width="1%">Precio</th>
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
		tabla = $('#tabla_productos').DataTable({
			"autoWidth": false,
			"language": {
				"url": base_url+"scripts/script_tablas/spanish.json"
			},
			serverSide: true,
			columns: [
				{ data: 'id', 'visible':false, 'orderable': true, 'searchable': false },
				{ data: 'icono', 'visible':true, 	'orderable': false, 'searchable': false },
				{ data: 'nombre',	'visible':true, 	'orderable': true, 'searchable': true },
				{ data: 'categoria_nombre',	'visible':true, 	'orderable': true, 'searchable': true, 'render': function(val, type, row) 
					{
						return '<span class="mismalinea">'+row.categoria_nombre+'</span>';
					}
				},
				{ data: 'precio',	'visible':true, 	'orderable': false, 'searchable': false, 'render': function(val, type, row) 
					{
						return '$'+row.precio;
					}
				},
				{ data: 'id', 'visible':true, 'searchable':false, 'orderable': false, 'render': function (val, type, row)
          			{
            			var opciones = '<div class="mismalinea">';
						opciones += '<a href="productos/editar/'+row.id+'" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-pencil"></i></a> ';
            			opciones += '</div>';

			            return opciones;
			    	}
			    }
			],
			order: [
				[ 0, 'asc' ]
			],
			ajax: {
				url: 'productos/lista',
				type: 'POST'
			}
		});
	});

</script>
