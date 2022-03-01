<header class="p-3 text-white fondo">
	    <div class="container">
	      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
	        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
	          <li><a href="index.php" class="nav-link px-2 btn btn-dark home">TDO</a></li>
	          <?php 
	          	if ( isset($_SESSION['usuario_actual'])){
	          		echo "<li><a href=\"cuenta.php\" class=\"nav-link px-2 text-white\">Cuenta</a></li>
	          			<li><a href=\"pedidos.php\" class=\"nav-link px-2 text-white\">Mis pedidos</a></li>";
	          	}
	          	?>
	          
	        </ul>

	        <div class="text-end d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">	

	          <?php 

	          	if ( isset($_SESSION['carro'])){
	          		echo "<a href=\"carro_1.php\" class=\"btn btn-dark\"><i class=\"fas fa-shopping-cart\"><spam> ".count($_SESSION['carro']['items'])." Items</spam></i></a>";
	          	}

	          	if ( !isset($_SESSION['usuario_actual'])){
	          		echo "<a  href=\"iniciar_sesion.php\" class=\"btn btn-warning\">Iniciar sesion</a>";	
	          	}else{
	          		echo "<form method=\"POST\" action=\"backend/cerrar_sesion.php\"><button type=\"submit\" id=\"btnCerrarSesion\" class=\"btn btn-warning\">Cerrar sesión </button></form>";
	          	}
	          ?>
	        </div>
	      </div>
	    </div>
    </header>