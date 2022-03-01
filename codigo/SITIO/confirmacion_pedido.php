<?php
session_start();
include('backend/funcionesBD.php');
include('backend/funcionesREST.php');
include('backend/configuracion.php');

if ( (!isset($_SESSION['usuario_actual'])) && (!isset($_SESSION['carro']))){
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
	<title><?php echo TITULO_SITIO;?> - Confirmar pedido</title>

	<?php include('modulos/librerias.php'); ?>

</head>
<body class="d-flex flex-column h-100">

	<?php include('encabezado.php');?>

	<div class="container contenedor">
		<h1>DETALLE DEL PEDIDO</h1>
		
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
			  	 $totalItems = count($_SESSION['carro']['items']);

			  	 for ( $i = 0; $i < $totalItems; $i++){

			  	 	$producto = obtenerProducto($_SESSION['carro']['items'][$i]['id_producto']);

			  	 	echo "<tr><th scope=\"row\">".($i+1)."</th>
			  	 			  <td>".$producto['nombre_producto']."</td>
			  	 			  <td>".$producto['codigo_producto']."</td>
			  	 			  <td>".$producto['precio_contado_producto']."</td>
			  	 			  <td>".$_SESSION['carro']['items'][$i]['cantidad']."</td>
			  	 			  <td>".$_SESSION['carro']['items'][$i]['total_item']."</td>
			  	 	      </tr>";

			  	 }
			  	?>
			  </tbody>
			</table>

			<div class="infoCarro">
				<?php echo "<h3>Monto: $".$_SESSION['carro']['monto_carro']."</h3>";
				  echo "<h3>Valor offercrips:".$_SESSION['carro']['offercrips_carro']."</h3>";
				?>
			</div>

		</div>
		
		<hr>

		<div class="container">
			<strong>
			<h2>Forma de entrega:</h2>
			<?php
				$formaEntrega = obtenerFormaEntrega($conexion['resultado'],$_SESSION['carro']['formaenvio_carro']);
				echo $formaEntrega['resultado']['nombre_formaenvio']." - ".$formaEntrega['resultado']['descripcion_formaenvio'];

				if ( $formaEntrega['resultado']['id_formaenvio'] == 2){
					echo " <b>El pedido será entregado en el domicilio: ".$_SESSION['usuario_actual']['domicilio_usuario']."</b>";
				}

			?>
			<hr>
			<h2>Forma de pago:</h2>
			<?php 
				$formaPago = obtenerFormaPago($conexion['resultado'],$_SESSION['carro']['formapago_carro']);
				echo $formaPago['resultado']['nombre_formapago']." - ".$formaPago['resultado']['descripcion_formapago'];

			?>
			</strong>
			<div class="contenedorBotones">
				<a class="btn btn-outline-secondary" href="carro_3.php">Volver</a>
				<button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">CANCELAR</button>
				<button class="btn btn-danger" id="btnConfirmar">CONFIRMAR</button>
			</div>
		</div>
	</div>
	<?php include('modal_eliminar_carro.php');?>
	<?php include('pie.php');?>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function() {
	
		<?php include('js/eliminar_carro.js');?>

		$('#btnConfirmar').click(function(){

			$.post('backend/procesar_pedido.php',function(resultado){
				//alert(resultado);
				console.log(resultado);
				if (resultado.error != null)
					alert(resultado.error);
				else
					location.href = 'pedido_finalizado.php';

			},'json');
		})

	})

</script>