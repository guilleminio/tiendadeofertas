<?php
session_start();
include('backend/configuracion.php');
include('backend/funcionesREST.php');
include('backend/funcionesBD.php');

if (!isset($_SESSION['usuario_actual'])){
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
$formasPago = null;
if( $conexion['resultado'] != null ){

	$resultado = obtenerFormasPago($conexion['resultado']);

	if ( $resultado['resultado'] != null )
		$formasPago = $resultado['resultado'];
	
}
?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo TITULO_SITIO;?> - Carro - Paso 3</title>

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
		<h2>Elige la forma de pago</h2>
		
		<table class="table">
			<?php
				$totalFormasPago = count($formasPago);

				for ( $i=0; $i < $totalFormasPago; $i++){

					$info = "<tr><td><div class=\"form-check\"><input class=\"form-check-input\" type=\"radio\" name=\"rbPago\" value=\"".$formasPago[$i]['id_formapago']."\"><label class=\"form-check-label\" for=\"".$formasPago[$i]['nombre_formapago']."\">".$formasPago[$i]['nombre_formapago']. " - ".$formasPago[$i]['descripcion_formapago']."<td></tr>";

					echo $info;

				}
			?>
		</table>

		<div class="contenedorBotones">
			<a class="btn btn-outline-secondary" href="carro_2.php">Volver</a>
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
    
				alert('Debes indicar una forma de pago');

    			return false;
			}
			
			return true;
		}


		$('#btnContinuar').click(function(){
			if ( formularioCompleto()){

				let formaPago = $('input[name=rbPago]:checked').val();
					
				$.post('backend/procesar_carro_3.php',{formaPago:formaPago},function(resultado){
						//alert(resultado);
						if (resultado.error != null)
							alert(resultado.error);
						else
							location.href = 'confirmacion_pedido.php';

					},'json');

			}
			
		})

	})

</script>