<!doctype html>
<html lang="es" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	
	<title>Tienda Online</title>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css"> -->
	<!-- <link rel="Shortcut Icon" href="<?php echo base_url(); ?>assets/img/favicon.png" /> -->

	<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script> var base_url = '<?php echo base_url(); ?>'; </script>

	<!-- Script datatable -->
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/script_tablas/jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>scripts/script_tablas/dataTables.bootstrap.min.js"></script>
    <link href="<?php echo base_url(); ?>scripts/script_tablas/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

    <style>
    	.mismalinea{
    		white-space: nowrap;
    	}
    </style>
</head>
<body>

	<nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px;">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo base_url(); ?>">Tienda<strong>Online</strong></a>
			</div>
	
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav navbar-right">
					<?php if($this->session->userdata('conectado')){ ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->session->userdata('usuario_nombre'); ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url(); ?>tienda">Mis compras</a></li>
							<li><a href="<?php echo base_url(); ?>tienda/configuracion">Editar configuración</a></li>
							<?php if($this->session->userdata('usuario_tipo') == 1){ ?>
							<li class="active"><a href="<?php echo base_url(); ?>panel">Panel administración</a></li>
							<?php } ?>
							<li><a href="<?php echo base_url(); ?>tienda/salir">Cerrar sesión</a></li>
						</ul>
					</li>
					<?php }else{ ?>
					<li><a data-toggle="modal" href="#modal-id">Ingresar</a></li>
					<?php } ?>
					<li><a href="<?php echo base_url(); ?>tienda/carrito">Carrito <span class="carrito_cantidad badge"><?php echo $this->cart->total_items(); ?></span></a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>