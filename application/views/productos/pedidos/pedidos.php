<div class="jumbotron">
	<div class="row menuInfoModulo">
		<div class="col-sm-6">
			<h2><?php echo $titulo; ?></h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore quia repudiandae, est placeat.</p>
		</div>
		<div class="col-sm-6 text-right">
			<div class="menuBotones">
				<a href="<?php echo base_url(); ?>admin/productos/categorias" class="btn btn-sm btn-default">Categorías</a> 
				<button type="button" class="btn btn-sm btn-primary" onclick="mostrar_ocultar_modulo('f_producto_nombre')"><i class="fa fa-plus"></i> Nuevo</button>
			</div>
		</div>
	</div>
</div>

<br>

<div class="container">
	<div class="row">
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-body text-center">
					<h3><?php echo $cant_compras; ?></h3>
					<small>PEDIDOS REALIZADOS</small>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-body text-center">
					<h3><?php echo $cant_productos; ?></h3>
					<small>PRODUCTOS SOLICITADOS</small>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-body text-center">
					<h3>$<?php echo number_format($cant_gasto,2,',','.'); ?></h3>
					<small>INGRESO TOTAL EN EL MES</small>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<!-- <div class="col-sm-12">
			<h3>Listado de mis compras</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit qui cum itaque atque quod consectetur reprehenderit saepe natus, temporibus, autem recusandae, dignissimos sed magnam ex inventore sunt animi libero doloribus?</p>
			<hr>
		</div> -->
		<div class="col-sm-12">
			
			<style>
				.content-general{
					margin-bottom: 25px;
				}
			</style>

			<div class="content-general">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default example" id="panel">
							<div class="panel-heading">
								<h3 class="panel-title">Lista mis compras</h3>
							</div>
							<table class="table table-hover" id="tabla_miscompras"  width="100%">
								<thead>
									<tr>
										<th width="1%"></th>
										<th width="1%"></th>
										<th width="1%" class="mismalinea">Fecha</th>
										<th width="1%">Hora</th>
										<th width="70%">Cliente</th>
										<th width="0%"></th>
										<th width="1%">Cantidad</th>
										<th width="1%">Total</th>
										<th width="1%">Estado</th>
										<th width="1%"></th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<br>
<br>
<br>

<!-- Función todavía no terminada -->
<div class="modal fade" id="cancelarPedido">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body text-center">
				<h4>¿Está seguro de querer cancelar el siguiente pedido?</h4>
				<p id="pedidoTexto"></p>
				<p><strong>* Función todavía no desarrollada *</strong></p>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="pedidoId" id="pedidoId">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-danger btn-sm">Cancelar</button>
			</div>
		</div>
	</div>
</div>

<script>
	tabla = $('#tabla_miscompras').DataTable({
		"autoWidth": false,
		"language": {
			"url": base_url+"scripts/script_tablas/spanish.json"
		},
		serverSide: true,
		columns: [
			{ data: 'id',		'visible':false, 	'orderable': true, 	'searchable': false },
			{ data: 'icono', 'visible':true, 	'orderable': false, 'searchable': false },
			{ data: 'creado',	'visible':true, 	'orderable': true, 'searchable': false, 'render': function(val, type, row) 
				{
					return row.creado_formateado;
				}
			},
			{ data: 'hora_formateado',	'visible':true, 	'orderable': false, 'searchable': false },
			{ data: 'cliente_nombre',	'visible':true, 	'orderable': true, 'searchable': true, 'render': function(val, type, row) 
				{
					return row.cliente_nombre_completo;
				}
			},
			{ data: 'cliente_apellido',	'visible':false, 	'orderable': false, 'searchable': true },
			{ data: 'cantidad',	'visible':true, 	'orderable': false, 'searchable': false, 'className': 'text-center' },
			{ data: 'total',	'visible':true, 	'orderable': false, 'searchable': false, 'render': function(val, type, row) 
				{
					return '$'+row.total
				}
			},
			{ data: 'estado',	'visible':true, 	'orderable': true, 'searchable': false, 'render': function(val, type, row) 
				{
					if(row.estado == 1){
						return '<span class="mismalinea">En espera</span>';
					}
				}
			},
			{ data: 'id', 'visible':true, 'searchable':false, 'orderable': false, 'render': function (val, type, row)
      			{
        			var opciones = '<div class="mismalinea">';
					opciones += '<a href="'+base_url+'admin/productos/pedidos/pedido/'+row.codigo+'" class="btn btn-sm btn-default"><i class="fa fa-eye"></i></a> ';
        			opciones += '</div>';

		            return opciones;
		    	}
		    }
		],
		order: [
			[ 2, 'asc' ],
			[ 3, 'desc' ]
		],
		ajax: {
			url: 'pedidos/lista',
			type: 'POST'
		}
	});

	function cancelar_pedido(id, fecha, hora){
		$('#pedidoTexto').html('Realizado el día '+fecha+' a las '+hora);
		$('#pedidoId').val(id);
		$('#cancelarPedido').modal('show');
	}
</script>