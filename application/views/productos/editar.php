<div class="jumbotron">
	<div class="row menuInfoModulo">
		<div class="col-sm-6">
			<h2>Administración de productos</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore quia repudiandae, est placeat.</p>
		</div>
		<div class="col-sm-6 text-right">
			<div class="menuBotones">
				<a href="<?php echo base_url(); ?>admin/productos/productos" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Volver</a> 
			</div>
		</div>
	</div>
</div>

<br>

<form action="<?php echo base_url(); ?>admin/productos/productos/guardar" method="post">
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Modificación de producto</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<div class="col-sm-6">
						<label for="f_producto_nombre">Nombre</label>
						<input type="text" name="f_producto_nombre" id="f_producto_nombre" class="form-control" value="<?php echo $producto->nombre; ?>">
					</div>
					<div class="col-sm-4">
						<label for="f_producto_categoria_id">Categoría</label>
						<select name="f_producto_categoria_id" id="f_producto_categoria_id" class="form-control">
							<option value="">Seleccione una opción</option>
							<?php foreach ($categorias as $categoria) { ?>
							<option value="<?php echo $categoria->id; ?>" <?php if($categoria->id == $producto->categoria_id){ echo 'selected'; } ?>><?php echo $categoria->nombre; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-sm-2">
						<label for="f_producto_precio">Precio</label>
						<input type="text" name="f_producto_precio" id="f_producto_precio" class="form-control" value="<?php echo $producto->precio; ?>">
					</div>
				</div>
			</div>
			<div class="panel-footer text-right">
				<input type="hidden" name="f_producto_codigo" id="f_producto_codigo" value="<?php echo $producto->codigo; ?>">
				<a href="<?php echo base_url(); ?>admin/productos/productos" class="btn btn-sm btn-default" onclick="mostrar_ocultar_modulo()">Cancelar</a>
				<button type="submit" class="btn btn-sm btn-primary">Guardar</button>
			</div>
		</div>
	</div>
</div>
</form>