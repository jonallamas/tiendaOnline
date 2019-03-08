<div class="jumbotron">
	<div class="row menuInfoModulo">
		<div class="col-sm-6">
			<h2><?php echo $titulo; ?></h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore quia repudiandae, est placeat.</p>
		</div>
		<div class="col-sm-6 text-right">
			<div class="menuBotones">
				<!-- <a href="<?php echo base_url(); ?>admin/usuarios/categorias" class="btn btn-sm btn-default">Categorías</a>  -->
				<button type="button" class="btn btn-sm btn-primary" onclick="mostrar_ocultar_modulo('f_usuario_apellido')"><i class="fa fa-plus"></i> Nuevo</button>
			</div>
		</div>
	</div>
</div>

<br>

<form action="<?php echo base_url(); ?>admin/usuarios/usuarios/guardar" method="post">
<div class="row" id="moduloCarga" style="display: none;">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Nuevo usuario</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<div class="col-sm-3">
						<label for="f_usuario_apellido">Apellido</label>
						<input type="text" name="f_usuario_apellido" id="f_usuario_apellido" class="form-control">
					</div>
					<div class="col-sm-3">
						<label for="f_usuario_nombre">Nombre</label>
						<input type="text" name="f_usuario_nombre" id="f_usuario_nombre" class="form-control">
					</div>
					<div class="col-sm-3">
						<label for="f_usuario_telefono">Teléfono</label>
						<input type="text" name="f_usuario_telefono" id="f_usuario_telefono" class="form-control">
					</div>
					<div class="col-sm-3">
						<label for="f_usuario_categoria_id">Categoría</label>
						<select name="f_usuario_categoria_id" id="f_usuario_categoria_id" class="form-control">
							<option value="">Seleccione una opción</option>
							<option value="1">Administrador</option>
							<option value="2">Cliente</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<legend style="margin-top: 20px; margin-bottom: 10px; font-size: 18px;">Información de ingreso</legend>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-4">
						<label for="f_usuario_correo">Correo electrónico</label>
						<input class="form-control" name="f_usuario_correo" id="f_usuario_correo">
					</div>
					<div class="col-sm-4">
						<label for="f_usuario_pass">Contraseña</label>
						<input class="form-control" onkeyup="validar_pass_panel()" name="f_usuario_pass" id="f_usuario_pass">
					</div>
					<div class="col-sm-4">
						<label for="f_usuario_pass_verificar">Verificar contraseña</label>
						<input class="form-control" onkeyup="validar_pass_panel()" name="f_usuario_pass_verificar" id="f_usuario_pass_verificar">
						<div class="error_pass" style="display: none;"></div>
					</div>
				</div>
			</div>
			<div class="panel-footer text-right">
				<button type="button" class="btn btn-sm btn-default" onclick="mostrar_ocultar_modulo()">Cancelar</button>
				<button type="submit" class="btn btn-sm btn-primary" id="btn_guardar_usuario" disabled>Guardar</button>
			</div>
		</div>
	</div>
</div>
</form>

<div class="row" id="moduloInformacion">
	<div class="col-sm-12">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Lista usuarios</h3>
			</div>
			<table class="table table-striped" id="tabla_usuarios"  width="100%">
				<thead>
					<tr>
						<th width="1%"></th>
						<th width="1%"></th>
						<th width="90%">Nombre completo</th>
						<th width="0%"></th>
						<th width="1%">Teléfono</th>
						<th width="1%">Tipo</th>
						<th width="1%">Validado</th>
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

	function validar_pass_panel(){
	    let pass        = $('#f_usuario_pass').val();
	    let pass_verif  = $('#f_usuario_pass_verificar').val();

	    if(pass != pass_verif){
	        $('.error_pass').fadeIn('fast', function(){
	            $('.error_pass').html('Contraseñas no coinciden');
	        });
	        $('#btn_guardar_usuario').prop('disabled', true);
	        return false;
	    }else{
	        $('.error_pass').fadeOut('fast', function(){
	            $('.error_pass').html('');
	        });
	        $('#btn_guardar_usuario').prop('disabled', false);
	        return true;
	    }
	}

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
		tabla = $('#tabla_usuarios').DataTable({
			"autoWidth": false,
			"language": {
				"url": base_url+"scripts/script_tablas/spanish.json"
			},
			serverSide: true,
			columns: [
				{ data: 'id', 'visible':false, 'orderable': true, 'searchable': false },
				{ data: 'icono', 'visible':true, 	'orderable': false, 'searchable': false },
				{ data: 'nombre',	'visible':true, 	'orderable': true, 'searchable': true, 'render': function(val, type, row) 
					{
						return row.nombre_completo;
					}
				},
				{ data: 'apellido',	'visible':false, 	'orderable': false, 'searchable': true },
				{ data: 'telefono',	'visible':true, 	'orderable': false, 'searchable': true, 'render': function(val, type, row) 
					{
						if(row.telefono != null){
							return row.telefono;
						}else{
							return '-';
						}
					}
				},
				{ data: 'tipo_id',	'visible':true, 	'orderable': true, 'searchable': false, 'render': function(val, type, row) 
					{
						if(row.tipo_id == 1){
							return 'Administrador';
						}else{
							return 'Cliente';
						}
					}
				},
				{ data: 'validado',	'visible':true, 	'orderable': false, 'searchable': false, 'className': 'text-center', 'render': function(val, type, row) 
					{
						if(row.validado == 1){
							return '<i class="fa fa-circle"></i>';
						}else{
							return '<i style="opacity: .35;" class="fa fa-circle"></i>';
						}
					}
				},
				{ data: 'id', 'visible':true, 'searchable':false, 'orderable': false, 'render': function (val, type, row)
          			{
            			var opciones = '<div class="mismalinea">';
						opciones += '<a href="usuarios/editar/'+row.codigo+'" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-pencil"></i></a> ';
            			opciones += '</div>';

			            return opciones;
			    	}
			    }
			],
			order: [
				[ 0, 'desc' ]
			],
			ajax: {
				url: 'usuarios/lista',
				type: 'POST'
			}
		});
	});

</script>
