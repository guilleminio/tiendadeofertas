<?php
session_start();
include('backend/configuracion.php');

if ( !isset($_SESSION['usuario_actual'])){
	header('Location:index.php');
	exit();
}
?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo TITULO_SITIO;?> - Registro exitoso</title>
	<?php include('modulos/librerias.php');?>
</head>
<body class="d-flex flex-column h-100">
	<?php include('encabezado.php');?>

	<div class="container contenedorMedio">
		<div class="tituloCentrado">
			<h1>¡BIENVENID@!</h1>
		</div>
		<div class="text-muted tituloCentrado">
			<h2>Ya eres miembr@ de la tienda de ofertas más importante del país.</h2>
			<h2>Como estamos tan content@s, te obsequiamos <strong><?php echo $_SESSION['usuario_actual']['offercrips'];?> offercrips</strong> para que lo uses en tu primera compra. ¡Disfrutalo!</h2>
		</div>
		<div>
			<a class="btn btn-danger" href="index.php">VER OFERTAS</a>
		</div>
		<div class="contenedorImagen">	
			<img src="imagenes/fin_registro.png" title="Familia Feliz" alt="Familia Feliz">
		</div>
	</div>

	<?php include('pie.php');?>
</body>
</html>