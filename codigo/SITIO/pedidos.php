<?php
session_start();
include('backend/configuracion.php');
include('backend/funcionesBD.php');

if ( !isset($_SESSION['usuario_actual'])){
	header('Location:iniciar_sesion.php');
	exit();
}

$conexion = conectarBD();

?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo TITULO_SITIO; ?> - Pedidos</title>

	<?php include('modulos/librerias.php'); ?>

</head>
<body class="d-flex flex-column h-100">

	<?php include('encabezado.php');?>

	<div class="container contenedor">

		<h1>Mis pedidos</h1>

		<div class="itemsCarro">
			
		  	<?php
		  	 
		  		$pedidos = null;

				if ( $conexion['resultado'] != null){

					$resultado = obtenerPedidos($conexion['resultado'],$_SESSION['usuario_actual']['id_usuario']);

					$totalPedidos = count($resultado['resultado']);

					if ( $totalPedidos > 0){

						echo "<table class=\"table table-bordered tablaItems\">
							  <thead>
							    <tr>
							      <th scope=\"col\">Orden</th>
							      <th scope=\"col\">Fecha</th>
							      <th scope=\"col\">Estado</th>
							      <th scope=\"col\">Monto</th>
							      <th scope=\"col\">Offercrips</th>
							    </tr>
							  </thead>
							  <tbody>";


						$i = 0;
						foreach( $resultado['resultado']  as $pedido){
	
							$pedidos[$i]['pedido'] = $pedido;

							$itemsPedido = obtenerItemsPedido($conexion['resultado'],$pedido['id_pedido']);

							$pedidos[$i]['items'] = $itemsPedido['resultado'];

							$estadoPedido = obtenerEstadoPedido($conexion['resultado'],$pedido['estado_pedido']);
						
							echo "<tr><th scope=\"row\"><a href=\"detalle_pedido.php?orden_pedido=".$pedido['id_pedido']."\">#".$pedido['id_pedido']."</a></th>
		  	 			  			<td>".$pedido['fecha_pedido']."</td>
		  	 			  			<td>".$estadoPedido['resultado']['nombre_estado']."</td>
		  	 			  			<td>".$pedido['monto_pedido']."</td>
		  	 			  			<td>".$pedido['offercrips_pedido']."</td></tr>";	

						}

						echo "</tbody></table>";

					}else{
						echo "<h2>Aún no tienes pedidos realizados.</h2>";
					}	

				}else{
					echo "<h2>No se pudieron encontrar los pedidos.</h2>";
				}

		  	?>
			
		</div>

		<div class="contenedorBotones">
			<a class="btn btn-outline-secondary" href="index.php">Volver</a>
		</div>

	</div>

	<?php include('pie.php'); ?>

</body>
</html>