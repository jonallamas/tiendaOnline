<div class="jumbotron">
	<div class="container">
		<h2>Mis compras</h2>
		<p>Apartado donde podrás ver todas las compras que has realizado.</p>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-body text-center">
					<h3><?php echo $cant_compras; ?></h3>
					<small>COMPRAS REALIZADAS</small>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-body text-center">
					<h3><?php echo $cant_productos; ?></h3>
					<small>PRODUCTOS ADQUIRIDOS</small>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-body text-center">
					<h3>$<?php echo number_format($cant_gasto,2,',','.'); ?></h3>
					<small>GASTO TOTAL EN EL MES</small>
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
		<div class="col-sm-8">
			
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
										<th width="1%" class="mismalinea">Fecha</th>
										<th width="90%">Hora</th>
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
			{ data: 'creado_formateado',	'visible':true, 	'orderable': true, 'searchable': false },
			{ data: 'hora_formateado',	'visible':true, 	'orderable': false, 'searchable': false },
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
					opciones += '<button onclick="cancelar_pedido('+row.id+', \''+row.creado_formateado+'\',\''+row.hora_formateado+'\')" class="btn btn-sm btn-danger">Cancelar pedido</button> ';
        			opciones += '</div>';

		            return opciones;
		    	}
		    }
		],
		order: [
			[ 1, 'desc' ],
			[ 2, 'desc' ]
		],
		ajax: {
			url: base_url+'tienda/lista_mis_compras',
			type: 'POST'
		}
	});

	function cancelar_pedido(id, fecha, hora){
		$('#pedidoTexto').html('Realizado el día '+fecha+' a las '+hora);
		$('#pedidoId').val(id);
		$('#cancelarPedido').modal('show');
	}
</script>