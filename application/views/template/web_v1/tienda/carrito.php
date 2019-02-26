<div class="jumbotron">
	<div class="container">
		<h2>Carrito de compras</h2>
		<p>Previsualiza los productos que estás por encargar.</p>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h3>Carrito de compras</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit ducimus tenetur praesentium provident dolore necessitatibus quaerat.</p>
			<hr>
			<div class="col-sm-8">
				<table class="table table-hover">
					<thead>
						<tr>
							<th width="90%">Nombre del producto</th>
							<th width="1%" class="text-right">Precio</th>
							<th width="1%">Cantidad</th>
							<th width="1%" class="text-right">Subtotal</th>
							<th width="1%"></th>
						</tr>
					</thead>
					<tbody>
						<?php if(count($this->cart->contents()) > 0){ ?>
						<?php foreach ($this->cart->contents() as $items){ ?>
						<tr id="carrito_producto_lista_<?php echo $items['id']; ?>">
							<td><?php echo $items['name']; ?></td>
							<td class="text-right">$<?php echo number_format($items['price'],2,',','.'); ?></td>
							<td class="text-center">
								<?php echo $items['qty']; ?>
								<input type="hidden" 
									value="<?php echo $items['qty']; ?>" 
									data-productoid="<?php echo $items['id']; ?>" 
									data-rowid="<?php echo $items['rowid']; ?>" 
									data-precio="<?php echo $items['price']; ?>" 
									id="cant_prod_<?php echo $items['id']; ?>" 
									name="cant_prod_<?php echo $items['id']; ?>" 
									class="carrito_producto_item form-control" 
									min="1" disabled />
							</td>
							<td class="text-right">$<span id="carrito_producto_<?php echo $items['id']; ?>_precio"><?php echo number_format($items['subtotal'],2,',','.'); ?></span></td>
							<td>
								<button onclick="carrito_producto_eliminar('<?php echo $items['rowid']; ?>');" class="btn btn-sm btn-default">X</button>
							</td>
						</tr>
						<?php } ?>
						<tr>
							<td colspan="3">Total:</td>
							<td>$<span id="carrito_total"><?php echo number_format($this->cart->total(),2,',','.'); ?></span></td>
							<td></td>
						</tr>
						<?php }else{ ?>
						<tr>
							<td colspan="5" class="text-center">No posee items en el carrito.</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php if(count($this->cart->contents()) > 0){ ?>
					<?php if($this->session->userdata('conectado')){ ?>
					<!-- Configuración de envío -->
					<?php if($configuracion->calle_nombre != ''){ ?>
					<div class="panel panel-default">
						<div class="panel-body">
							<p style="margin-bottom: 0px;">
								Posee registrada una dirección en <strong><?php echo $configuracion->calle_nombre; ?></strong> N° <strong><?php echo $configuracion->calle_numero; ?></strong>. ¿Desea que se lo enviemos ahí?
								<a href="<?php echo base_url(); ?>tienda/configuracion" class="btn btn-xs btn-default pull-right"><i class="fa fa-pencil"></i></a>
							</p>
						</div>
					</div>
					<?php } ?>

					<!-- Para encargar -->
					<div class="alert alert-info">
						<strong>¡Felicitaciones!</strong> Ahora usted puede comprar. <a href="<?php echo base_url(); ?>tienda/encargar" class="btn-link pull-right">Encargar</a>
					</div>
					<?php }else{ ?>
					<div class="alert alert-danger">
						<strong>¡Atención!</strong> Debe iniciar sesión para poder comprar. <button style="margin-top: -3px;" class="btn-link pull-right" id="btnRegistro">Registrarme</button>
					</div>
					<?php } ?>
				<?php } ?>

			</div>
		</div>
	</div>
</div>

<br>
<br>
<br>
<br>