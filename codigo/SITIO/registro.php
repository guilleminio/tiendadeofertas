<?php
session_start();
include('backend/configuracion.php');

if (!isset($_SESSION['registro'])){
	header('Location:iniciar_sesion.php');
}

?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo TITULO_SITIO;?> - Registro</title>

	<?php include('modulos/librerias.php');?>

</head>
<body class="d-flex flex-column h-100">
	<?php include('encabezado.php');?>

	<section class="flex-shrink-0">
		<div class="container" id="formularioRegistro">
	        <h2>CREA TU CUENTA</h2>
	        
	        <div class="form-group">
	            <label for="nombre">Nombre*</label>
	            <input type="text" class="form-control" placeholder="Nombre" id="nombre">
	        </div>
	        <div class="form-group">
	            <label for="apellido">Apellido*</label>
	            <input type="text" class="form-control" placeholder="Apellido" id="apellido">
	        </div>
	        <div class="form-group">
	            <label for="email">Email</label>
	            <input type="email" class="form-control" placeholder="Email" id="email" disabled value="<?php echo $_SESSION['registro']['email'];?>">
	        </div>
	        <div class="form-group">
	            <label for="telefono">Teléfono*</label>
	            <input type="phone" class="form-control" placeholder="Teléfono" id="telefono">
	        </div>
	        <div class="form-group">
	            <label for="domicilio">Domicilio*</label>
	            <input type="text" class="form-control" placeholder="Domicilio" id="domicilio">
	        </div>
	        
	        <div class="clearfix"></div>
	        <button class="btn btn-danger btn-lg" id="btnRegistrar"> REGISTRARSE</button>	       
	    </div>
	</section>

	<?php include('pie.php');?>
</body>
</html>
<script type="text/javascript">

	$(document).ready(function() {
		
		function mostrarMensaje(data,input){
			alert(data);
			$('#'+input).focus();
		}

		function formularioCompleto(){

			if ( $('#nombre').val().length == 0){
				mostrarMensaje('Debes indicar tu nombre','nombre');
				return false;
			}

			if ( $('#apellido').val().length == 0){
				mostrarMensaje('Debes indicar tu apellido','apellido');
				return false;
			}

			if ( $('#telefono').val().length == 0){
				mostrarMensaje('Debes indicar un telefono','telefono');
				return false;
			}

			if ( $('#domicilio').val().length == 0){
				mostrarMensaje('Debes indicar un domicilio','domicilio');
				return false;
			}

			return true;
		}
	
		$('#btnRegistrar').click(function(){

			if ( formularioCompleto()){

				let nombre      = $('#nombre').val();
				let apellido    = $('#apellido').val();
				let telefono    = $('#telefono').val();
				let domicilio   = $('#domicilio').val();

				$.post('backend/procesar_registro_2.php',{nombre:nombre,apellido:apellido,telefono:telefono,domicilio:domicilio},function (resultado) {
						//alert(resultado);
						
						if ( resultado.error != null)
							alert(resultado.error);
						else
							location.href='registro_exitoso.php';
				},'json')

			}

		})
	})

</script>