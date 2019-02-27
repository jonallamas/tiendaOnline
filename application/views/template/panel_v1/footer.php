	</div>

	<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/script.js"></script>

	<script>

		var estado_modulo = 0;
		function mostrar_ocultar_modulo(nombre_imput){
			if(estado_modulo == 0){
				$('#moduloInformacion').fadeOut('fast', function(){
					$('#moduloCarga').fadeIn();
					$('#'+nombre_imput).focus();
					estado_modulo = 1;
				});
			}else{
				$('#moduloCarga').fadeOut('fast', function(){
					$('#moduloInformacion').fadeIn();
					estado_modulo = 0;
				});
			}
		}

	</script>
</body>
</html>