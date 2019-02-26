	<form action="" method="post" id="f_login" name="f_login">
		<div class="modal fade" id="modal-id">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-body">
				      	<div class="login-body">
				      	  	<div class="form-group">
				            	<label for="modal_login_correo">Correo electrónico:</label>
				            	<input type="text" name="modal_login_correo" id="modal_login_correo" class="form-control" value="" autocomplete="off">
				          	</div>
				      	  	<div class="form-group">
				            	<label for="modal_login_pass">Contraseña:</label>
				            	<input type="password" name="modal_login_pass" id="modal_login_pass" class="form-control" value="" placeholder="*****" autocomplete="off">
				          	</div>
				          	<div id="modal_alerta_login" style="display: none;"></div>
				      	  	<input type="hidden" name="log_idioma" id="log_idioma" class="form-control" value="spanish">
					    	<button type="submit" class="btn btn-primary btn-block" id="modalbtnIngresar">Ingresar</button>
				      	  	<!-- <button type="button" class="btn btn-block btn-default" id="btnRegistro">Registrarme</button> -->
				      	</div>
				      	<div class="registro-body" style="display: none;">
			      			<div class="form-group">
			      				<label for="f_registro_apellido">Apellido</label>
			      				<input type="text" name="f_registro_apellido" id="f_registro_apellido" class="form-control">
			      			</div>
			      			<div class="form-group">
			      				<label for="f_registro_nombre">Nombre</label>
			      				<input type="text" name="f_registro_nombre" id="f_registro_nombre" class="form-control">
			      			</div>
			      			<div class="form-group">
			      				<label for="f_registro_correo">Correo</label>
			      				<input type="text" name="f_registro_correo" id="f_registro_correo" class="form-control">
			      			</div>
			      			<div id="modal_alerta_registro_correo" style="display: none;"></div>
			      			<div class="form-group">
			      				<label for="f_registro_pass">Contraseña</label>
			      				<input type="password" name="f_registro_pass" id="f_registro_pass" class="form-control">
			      			</div>
			      			<div class="form-group">
			      				<label for="f_registro_pass_verificar">Verificar contraseña</label>
			      				<input type="password" name="f_registro_pass_verificar" id="f_registro_pass_verificar" onkeyup="validar_pass()" class="form-control">
			      			</div>
			      			<div id="modal_alerta_registro" style="display: none;"></div>
				      	  	<input type="hidden" name="log_idioma" id="log_idioma" class="form-control" value="spanish">
					    	<button type="submit" class="btn btn-primary btn-block" id="modalbtnRegistrarme">Registrarme</button>
				      	  	<!-- <button type="button" class="btn btn-block btn-default" id="btnIngreso">Ingresar</button> -->
				      	</div>
					</div>
					<!-- <div class="modal-footer"> -->
						<!-- <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button> -->
					<!-- </div> -->
				</div>
			</div>
		</div>
	</form>

	<style>
		footer{
			background-color: #333; 
			color: #ccc;
			padding: 25px 0px;
		}
	</style>

	<footer>
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					Todos los derechos reservados y esas cosas.
				</div>
				<div class="col-sm-6 text-right">
					<small>Copyright © Tienda<strong>Online</strong></small>
				</div>
			</div>
		</div>
	</footer>

	<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/script.js"></script>
</body>
</html>