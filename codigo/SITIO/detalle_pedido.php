<?php
session_start();
include('backend/configuracion.php');
include('backend/funcionesBD.php');
include('backend/funcionesREST.php');

if ( !isset($_SESSION['usuario_actual']) || !isset($_GET['orden_pedido'])){
	header('Location:iniciar_sesion.php');
	exit();
}

$conexion = conectarBD();

$idpedido = strip_tags(addslashes($_GET['orden_pedido']));

$resultado = obtenerPedido($conexion['resultado'],$idpedido);

$pedido = $resultado['resultado'];

$resultado = obtenerItemsPedido($conexion['resultado'],$idpedido);

$itemsPedido = $resultado['resultado'];
?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo TITULO_SITIO;?> - Detalle pedido <?php echo "#".$idpedido;?></title>

	<?php include('modulos/librerias.php'); ?>

</head>
<body class="d-flex flex-column h-100">

	<?php include('encabezado.php');?>

	<div class="container contenedor">
		<h1>DETALLE DEL PEDIDO <?php echo "#".$idpedido;?></h1>
		
		<div class="itemsCarro">
			<table class="table table-bordered">
			  <thead>
			    <tr>
			      <th scope="col">Item</th>
			      <th scope="col">Nombre</th>
			      <th scope="col">Código</th>
			      <th scope="col">Precio unitario</th>
			      <th scope="col">Cantidad</th>
			      <th scope="col">Total</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php
			  	 $totalItems = count($itemsPedido);

			  	 for ( $i = 0; $i < $totalItems; $i++){

			  	 	$producto = obtenerProducto($itemsPedido[$i]['id_producto']);

			  	 	echo "<tr><th scope=\"row\">".$itemsPedido[$i]['id_item']."</th>
			  	 			  <td>".$producto['nombre_producto']."</td>
			  	 			  <td>".$producto['codigo_producto']."</td>
			  	 			  <td>".$itemsPedido[$i]['precio_unitario_item']."</td>
			  	 			  <td>".$itemsPedido[$i]['cantidad_item']."</td>
			  	 			  <td>".$itemsPedido[$i]['precio_total_item']."</td>
			  	 	      </tr>";

			  	 }
			  	?>
			  </tbody>
			</table>

			<div class="infoCarro">
				<?php echo "<h3>Monto: $".$pedido['monto_pedido']."</h3>";
				  echo "<h3>Valor offercrips:".$pedido['offercrips_pedido']."</h3>";
				?>
			</div>

		</div>
		
		<hr>

		<div class="container">
			<strong>
			<h2>Forma de entrega:</h2>
			<?php
				$formaEntrega = obtenerFormaEntrega($conexion['resultado'],$pedido['formaenvio_pedido']);
				echo $formaEntrega['resultado']['nombre_formaenvio']." - ".$formaEntrega['resultado']['descripcion_formaenvio'];

				if ( $formaEntrega['resultado']['id_formaenvio'] == 2){
					echo " <b>El pedido será entregado en el domicilio: ".$_SESSION['usuario_actual']['domicilio_usuario']."</b>";
				}

			?>
			<hr>
			<h2>Forma de pago:</h2>
			<?php 
				$formaPago = obtenerFormaPago($conexion['resultado'],$pedido['formapago_pedido']);
				echo $formaPago['resultado']['nombre_formapago']." - ".$formaPago['resultado']['descripcion_formapago'];

			?>
			</strong>
			<div class="contenedorBotones">
				<a class="btn btn-outline-secondary" href="pedidos.php">Volver</a>
			</div>
		</div>
	</div>
	<?php include('pie.php');?>
</body>
</html>