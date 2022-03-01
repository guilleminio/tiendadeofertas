<?php
session_start();
include('backend/funcionesREST.php');
include('backend/configuracion.php');
?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Miño, G.">
	<title><?php echo TITULO_SITIO;?> - Página principal</title>

	<?php include('modulos/librerias.php');?>
</head>
<body class="d-flex flex-column h-100">
	
	<?php include('encabezado.php') ?>

    <section>
    	<div class="position-relative overflow-hidden p-3 p-md-5 text-center bg-light onlinecommerce">
    		<div class="col-md-5 p-lg-5 mx-auto my-5 presentacion">
      			<h1 class="display-4 fw-normal">TIENDA DE OFERTAS</h1>
      			<p class="lead fw-normal">Variedad de productos al mejor precio</p>
      			<a class="btn btn-danger" href="iniciar_sesion.php">Comenzá ahora</a>
    		</div>
  		</div>

  		<div class="titulo">
  			<h1>OFERTAS DEL MOMENTO</h1>
  		</div>

  		<div class="album py-5 bg-light">
    		<div class="container">
      			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        			
      				<?php

      				  $ofertas = obtenerOfertas();

      				  $totalOfertas = count($ofertas);

      				  if ( $totalOfertas > 0 ){

      				  		for ( $i = 0; $i < $totalOfertas; $i++ ){

      				  			echo "<div class=\"col escalarImagen\">
          								<div class=\"card shadow-sm\">
            								<img src=\"".$ofertas[$i]['imagen_oferta']."\">
            								<div class=\"card-body tarjeta\">
              									<p class=\"card-text\">".$ofertas[$i]['nombre_oferta']."</p>
              									<div class=\"d-flex justify-content-center align-items-center\">
                  									<a href=\"detalle_producto.php?id_oferta=".$ofertas[$i]['id_oferta']."\" type=\"button\" class=\"btn btn-sm btn-outline-secondary botonShop\">VER OFERTA</a>
              									</div>
            								</div>
          								</div>
        							  </div>";
      				  		}

      				  }
      				?>
    			</div>
  			</div>
  		</div>	

    </section>

    <?php include('pie.php');?>
</body>
</html>
