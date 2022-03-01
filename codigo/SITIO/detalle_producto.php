<?php
session_start();
include('backend/funcionesREST.php');
include('backend/configuracion.php');

$idoferta = null;
$oferta   = null;
$producto = null;

if (isset($_GET)){
	$idoferta = strip_tags(addslashes($_GET['id_oferta']));
	$oferta   = obtenerOferta($idoferta);
	$producto = obtenerProducto($oferta['producto_oferta']);
	$offercripsSumar = ($producto['precio_contado_producto']*($oferta['descuento_oferta']/100))/VALOR_OFFERCRIP;
?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Miño, G.">
	<title><?php TITULO_SITIO;?> - Producto</title>

	<?php include('modulos/librerias.php');?>

</head>
<body class="d-flex flex-column h-100">

	<?php include('encabezado.php'); ?>

	<div class="container contenedor">

		<div class="detalleProducto">

			<?php
				
				echo "<img src=\"".$producto['imagen_producto']."\" >";

				echo "<div class=\"lens\"></div>
            			<div class=\"result\"></div>";
			?>
			
		</div>

		<div class="detalleProducto">
			<h1><?php echo $oferta['nombre_oferta']  ?></h1>
			<h2><?php echo $producto['nombre_producto'];?></h2>

			<div class="contenedorPrecios">
				<ul>
				<li>Precio contado: $<?php echo $producto['precio_contado_producto']." (".$oferta['descuento_oferta']."% off)"; ?></li>
				<li>Precio offercrips: <?php echo $producto['precio_contado_producto']/VALOR_OFFERCRIP; ?></li>
				<li>Sumás: <?php echo $offercripsSumar;?></li>
				</ul>
			</div>

			<div class="descripcionProducto">
				<p><?php echo $producto['descripcion_producto'];?></p>
			</div>

			<div>
				<p><strong>Stock: <?php echo $producto['stock_producto'];?></strong></p>
			</div>

			<div class="contenedorCompra">
				<p><strong>Cantidad:</strong></p>
				<?php
					echo "<select id=\"cantidad\" class=\"form-select\" >";
					$stock = $producto['stock_producto'];
					for ( $i = 1; $i <= $stock;$i++){
						echo "<option value=\"".$i."\">".$i."</option>";
					}
					echo "</select>";
				?>
			</div>
			<div class="botonComprar">
					<button id="btnComprar" class="btn btn-danger">COMPRAR</button>
			</div>
			

		</div>
	</div>

	<?php include('pie.php'); ?>

</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){

		$('#btnComprar').click(function(){

			let producto = <?php echo $producto['id_producto'];?>;
			let precio = <?php echo $producto['precio_contado_producto'];?>;
			let offercrips = <?php echo $producto['precio_contado_producto']/VALOR_OFFERCRIP;?>;
			let sumaoffercrips = <?php echo $offercripsSumar;?>;
			let cantidad = $('#cantidad').val();

			$.post('backend/agregar_carro.php',{producto:producto,precio:precio,offercrips:offercrips,sumaoffercrips:sumaoffercrips,cantidad:cantidad},function(resultado){
					//alert(resultado);
					if ( resultado.error !=null){
						alert(resultado.error);
					}else{
						location.href='carro_1.php';
					}

			},'json');
		})

	})
</script>
<?php

}else{
	header('Location:index.php');
	exit();
}
?>