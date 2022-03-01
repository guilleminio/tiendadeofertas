<?php
session_start();
include('backend/funcionesREST.php');
include('backend/funcionesBD.php');
include('backend/configuracion.php');

if ( !isset($_SESSION['usuario_actual'])){

	if (!isset($_SESSION['carro'])){

		header('Location:index.php');
		exit();
		
	}else{
		$_SESSION['pagina_actual'] = 'carro_1.php';
		header('Location:iniciar_sesion.php');
		exit();	
	}
	
}

$conexion = conectarBD();
$formasEntrega = null;
if( $conexion['resultado'] != null ){

	$resultado = obtenerFormasEntrega($conexion['resultado']);

	if ( $resultado['resultado'] != null )
		$formasEntrega = $resultado['resultado'];
	
}
?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo TITULO_SITIO;?> - Carro - Paso 2</title>

	<?php include('modulos/librerias.php');?>
</head>
<body class="d-flex flex-column h-100">
	<?php include('encabezado.php');?>

	<div class="container contenedor">

		<h1>CARRITO DE COMPRAS</h1>
		
		<div class="itemsCarro">
			
			<table class="table table-bordered tablaItems">
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
	</div>

	<div class="container">
		<h2>Elige la forma de entrega</h2>
			
		<table class="table">
			<?php
				$totalFormasEnvio = count($formasEntrega);

				for ( $i=0; $i < $totalFormasEnvio; $i++){

					$info = "<tr><td><div class=\"form-check\"><input  class=\"form-check-input\" type=\"radio\" name=\"rbEntrega\" value=\"".$formasEntrega[$i]['id_formaenvio']."\"><label class=\"form-check-label\" for=\"".$formasEntrega[$i]['nombre_formaenvio']."\">".$formasEntrega[$i]['nombre_formaenvio']. " - ".$formasEntrega[$i]['descripcion_formaenvio']."</div><td></tr>";
					echo $info;
				}
			?>
		</table>


		<div class="contenedorBotones">
			<a class="btn btn-outline-secondary" href="carro_1.php">Volver</a>
			<button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">Vaciar carro</button>
			<button class="btn btn-danger" id="btnContinuar">Continuar</button>
		</div>	

	</div>
	<?php include('modal_eliminar_carro.php');?>
	<?php include('pie.php');?>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function() {
	
		<?php include('js/eliminar_carro.js');?>


		function formularioCompleto(){

			if ($("input[type=radio]:checked").length <= 0) {
    
				alert('Debes indicar una forma de entrega');

    			return false;
			}
			
			return true;
		}


		$('#btnContinuar').click(function(){

			if ( formularioCompleto()){

				let formaEnvio = $('input[name=rbEntrega]:checked').val();
		
				$.post('backend/procesar_carro_2.php',{formaEnvio:formaEnvio},function(resultado){
						//alert(resultado);
						if (resultado.error != null)
							alert(resultado.error);
						else
							location.href = 'carro_3.php';

					}

			,'json')};
		})

	})

</script>