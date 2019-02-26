<div class="jumbotron">
	<div class="container">
		<h2>Información de envío</h2>
		<p>Configure la información de envío para que le lleguen los productos que compró.</p>
	</div>
</div>

<style>
	/*.panel-with-nav .nav-tabs{
		border-bottom: 0px;
	}
	.panel-with-nav.panel-heading{
		padding: 7px;
		padding-bottom: 0px;
	}*/
</style>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<form action="<?php echo base_url(); ?>tienda/guardar_configuracion" method="POST">
				<div class="panel panel-default">
					<div class="panel-heading panel-with-nav">
						<!-- <ul class="nav nav-tabs"> -->
							<!-- <li class="active"><a href="#tab1" data-toggle="tab">Incio</a></li> -->
							<!-- <li><a href="#tab2" data-toggle="tab">Contacto</a></li> -->
						<!-- </ul> -->
						<h3 class="panel-title">Configuración</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-7">
								<label for="f_config_calle_nombre">Dirección de envío</label>
								<input type="text" name="f_config_calle_nombre" id="f_config_calle_nombre" class="form-control" value="<?php echo $configuracion->calle_nombre; ?>">
							</div>
							<div class="col-sm-1">
								<label for="f_config_calle_numero">Número</label>
								<input type="text" name="f_config_calle_numero" id="f_config_calle_numero" class="form-control" value="<?php echo $configuracion->calle_numero; ?>">
							</div>
							<div class="col-sm-1">
								<label for="f_config_cp">Cód. postal</label>
								<input type="text" name="f_config_cp" id="f_config_cp" class="form-control" value="<?php echo $configuracion->codigo_postal; ?>">
							</div>
							<div class="col-sm-1">
								<label for="f_config_piso">Piso</label>
								<input type="text" name="f_config_piso" id="f_config_piso" class="form-control" value="<?php echo $configuracion->piso; ?>">
							</div>
							<div class="col-sm-2">
								<label for="f_config_departamento">Departamento</label>
								<input type="text" name="f_config_departamento" id="f_config_departamento" class="form-control" value="<?php echo $configuracion->departamento; ?>">
							</div>
						</div>
						<!-- <div class="tab-content"> -->
							<!-- <div class="tab-pane fade active in" id="tab1"> -->
								<!-- <p>Primero</p> -->
							<!-- </div> -->
							<!-- <div class="tab-pane fade" id="tab2"> -->
								<!-- <p>Segundo</p> -->
							<!-- </div> -->
						<!-- </div> -->
					</div>
					<div class="panel-footer text-right">
						<input type="hidden" name="f_config_id" id="f_config_id" value="<?php echo $configuracion->id; ?>">
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>