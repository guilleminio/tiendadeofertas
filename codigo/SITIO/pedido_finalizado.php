<?php
session_start();
include('backend/configuracion.php');

if (!isset($_SESSION['usuario_actual'])){
	header('Location:iniciar_sesion.php');
}
?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo TITULO_SITIO;?> - Pedido finalizado</title>

	<?php include('modulos/librerias.php'); ?>

</head>
<body class="d-flex flex-column h-100">

	<?php include('encabezado.php');?>
	<div class="container contenedorMedio">
		<div class="tituloCentrado">
			<h1>¡GRACIAS POR TU COMPRA!</h1>
		</div>
		<div class="text-muted tituloCentrado">
			<h2>Tu pedido con orden <mark><strong>#<?php echo $_SESSION['orden_pedido'];?></strong></mark>  está siendo procesado. En breve nos comunicaremos contigo para coordinar la entrega.</h2>
		</div>
		<div>
			<a class="btn btn-danger" href="index.php">VER MÁS OFERTAS</a>
		</div>
		<div class="contenedorImagen">	
			<img src="imagenes/shop.jpg" title="Familia Feliz" alt="Familia Feliz">
		</div>
	</div>
	<?php include('pie.php');?>
</body>
</html>