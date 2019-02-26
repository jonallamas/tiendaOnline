<div class="jumbotron">
	<div class="container">
		<h1>¡Tu Tienda<strong>Online</strong>!</h1>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore quae maiores eveniet, voluptatibus sunt odit ut perspiciatis quibusdam voluptatem quo quis delectus aliquid iure iste, natus ipsam eius sint consectetur.</p>
		<p>
			<a class="btn btn-primary">Leer más</a>
		</p>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h2>Sección de productos</h2>
			<hr>
		</div>
		<?php foreach ($productos as $producto) { ?> 
		<div class="col-sm-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo $producto->nombre; ?> <span class="pull-right badge"><?php echo $producto->categoria_nombre; ?></span></h3>
				</div>
				<div class="panel-body">
					Este producto posee un precio de <strong>$<?php echo $producto->precio; ?></strong>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8">
							<div class="input-group">
								<span class="input-group-addon">Cantidad</span>
								<input type="text" name="cantidad" id="producto_cantidad_<?php echo $producto->id; ?>" class="form-control" value="1">
							</div>
						</div>
						<div class="col-sm-4">
							<button type="button" onclick="carrito_producto_agregar('<?php echo $producto->id; ?>', '<?php echo $producto->precio; ?>', '<?php echo $producto->nombre; ?>');" class="btn btn-sm btn-primary">Agregar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>

<br>
<br>
<br>
<br>
	