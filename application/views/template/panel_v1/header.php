<!doctype html>
<html lang="es" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	
	<title>Tienda Online | <?php echo $titulo; ?></title>

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

    <?php 

    	define('base_panel', base_url().'panel/');

    ?>

    <style>
    	.mismalinea{
    		white-space: nowrap;
    	}

    	.menuInfoModulo h2{
    		margin-top: 0px;
    		margin-bottom: 0px;
    	}
    	.menuInfoModulo .menuBotones{
    		padding-top: 20px;
    	}
    </style>
</head>
<body>

	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo base_panel; ?>">Tienda<strong>Online</strong></a>
			</div>
	
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="<?php if($seccion_menu == 'tienda_usuarios'){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>admin/usuarios/usuarios">Usuarios</a></li>
					<!-- <li class="<?php if($seccion_menu == 'tienda_productos'){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>admin/productos/productos">Productos</a></li> -->
					<li class="dropdown <?php if($seccion_menu == 'tienda_productos'){ echo 'active'; } ?>">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">Productos <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url(); ?>admin/productos/productos">Productos</a></li>
							<li><a href="<?php echo base_url(); ?>admin/productos/pedidos">Pedidos</a></li>
						</ul>
					</li>
					
					<!-- Separador momentaneo -->
					<li><a></a></li>
					<!--  -->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->session->userdata('usuario_nombre'); ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_panel; ?>/salir">Cerrar sesión</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>

	<div class="container">