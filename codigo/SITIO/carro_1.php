<?php
session_start();
include('backend/funcionesREST.php');
include('backend/configuracion.php');

if (!isset($_SESSION['carro'])){
	header('Location:index.php');
	exit();
} 
?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo TITULO_SITIO;?> - Carro - Paso 1</title>

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
			      <th scope="col">Producto</th>
			      <th scope="col">Nombre</th>
			      <th scope="col">Código</th>
			      <th scope="col">Precio unitario</th>
			      <th scope="col">Cantidad</th>
			      <th scope="col">Total</th>
			      <th scope="col">Eliminar</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php
			  	 $totalItems = count($_SESSION['carro']['items']);

			  	 for ( $i = 0; $i < $totalItems; $i++){

			  	 	$producto = obtenerProducto($_SESSION['carro']['items'][$i]['id_producto']);

			  	 	echo "<tr><th scope=\"row\">".($i+1)."</th>
			  	 			  <td class=\"imagenitemcarro\"><img  src=\"".$producto['imagen_producto']."\"></td>
			  	 			  <td>".$producto['nombre_producto']."</td>
			  	 			  <td>".$producto['codigo_producto']."</td>
			  	 			  <td>".$producto['precio_contado_producto']."</td>
			  	 			  <td>".$_SESSION['carro']['items'][$i]['cantidad']."</td>
			  	 			  <td>".$_SESSION['carro']['items'][$i]['total_item']."</td>
			  	 			  <td><button id=\"".$i."\" name=\"btnEliminar-".$i."\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></button></td>
			  	 	      </tr>";

			  	 }
			  	?>
			  </tbody>
			</table>
		</div>
		<div class="infoCarro">
			<?php echo "<h3>Monto: $".$_SESSION['carro']['monto_carro']."</h3>";
				  echo "<h3>Valor offercrips:".$_SESSION['carro']['offercrips_carro']."</h3>";
			?>
		</div>

		<div class="contenedorBotones">
			<a class="btn btn-outline-secondary" href="index.php">Ver mas ofertas</a>
			<button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">Vaciar carro</button>
			<a class="btn btn-danger" href="carro_2.php">Continuar</a>
		</div>	

	</div>
	
	<?php include('modal_eliminar_carro.php');?>
	<?php include('pie.php');?>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){

		$( "button[name|='btnEliminar']" ).click(function(){
			let item = this.id;

			$.post('backend/eliminar_item_carro.php',{item:item},function(resultado){
				//alert(resultado);
				
				if ( resultado.error!=null){
					alert(resultado_error);
				}else{
					alert('Se ha eliminado un item de su carro');
					location.reload();
				}
			},'json')

		})

		<?php include('js/eliminar_carro.js');?>
	})

</script>