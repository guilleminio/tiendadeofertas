<?php
session_start();

if ( !isset($_SESSION['usuario_actual'])){
	header('Location:iniciar_sesion.php');
}


include('backend/configuracion.php');
?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo TITULO_SITIO?> - Mi cuenta</title>

	<?php include('modulos/librerias.php'); ?>

</head>
<body class="d-flex flex-column h-100">

	<?php include('encabezado.php');?>

	<div class="container contenedorCuenta">

		<h1>Mi cuenta</h1>

		<div class="container contenedorCuenta">
			<div >
				 <div class="row mb-3">
					<label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
					<div class="col-sm-8">
 				 		<input type="text" class="form-control" id="nombre" value="<?php echo $_SESSION['usuario_actual']['nombre_usuario']?>">
					</div>
				</div>
				<div class="row mb-3">
				    <label for="apellido" class="col-sm-2 col-form-label">Apellido</label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="apellido" value="<?php echo $_SESSION['usuario_actual']['apellido_usuario']?>">
				    </div>
				</div>
			  	<div class="row mb-3">
				    <label for="email" class="col-sm-2 col-form-label">Email</label>
				    <div class="col-sm-8">
				      <input type="email" class="form-control" id="email" value="<?php echo $_SESSION['usuario_actual']['email_usuario']?>">
				    </div>
				</div>
				<div class="row mb-3">
				    <label for="contrasenia" class="col-sm-2 col-form-label">Contrasenia</label>
				    <div class="col-sm-8">
				      <input type="password" class="form-control" id="contrasenia" value="<?php echo $_SESSION['usuario_actual']['pass']?>">
				    </div>
				</div>
				<div class="row mb-3">
				    <label for="repetircontrasenia" class="col-sm-2 col-form-label">Repetir contraseña:</label>
				    <div class="col-sm-8">
				      <input type="password" class="form-control" id="repetircontrasenia">
				    </div>
				</div>
				<div class="row mb-3">
				    <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="telefono" value="<?php echo $_SESSION['usuario_actual']['telefono_usuario']?>">
				    </div>
				</div>
				<div class="row mb-3">
				    <label for="domicilio" class="col-sm-2 col-form-label">Domicilio</label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="domicilio" value="<?php echo $_SESSION['usuario_actual']['domicilio_usuario']?>">
				    </div>
				</div>
				<div class="row mb-3">
					<h3>Tu saldo de offercrips: <?php  echo $_SESSION['usuario_actual']['offercrips'];?></h3>
				</div>
			  	<div class="col-10 botonesCentro">
			  		<button id="btnCancelar" class="btn btn-outline-secondary">Cancelar</button>
			  		<button id="btnActualizar" class="btn btn-danger">Actualizar</button>
			  	</div>
			</div>
		</div>
	</div>

	<?php include('pie.php');?>

</body>
</html>

<script type="text/javascript">
	
	$(document).ready(function(){

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

			if ( $('#email').val().length == 0){
				mostrarMensaje('Debes indicar un email','email');
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

			if ( $('#contrasenia').val().length == 0){
				mostrarMensaje('Debes indicar una contrasenia','contrasenia');
				return false;
			}

			if ( $('#repetircontrasenia').val().length == 0){
				mostrarMensaje('Debes confirmar la contrasenia','repetircontrasenia');
				return false;
			}

			return true;
		}

		$('#btnCancelar').click(function() {
			location.href='index.php';
		})

		$('#btnActualizar').click(function(){

			if (formularioCompleto()){

				let nombre      = $('#nombre').val();
				let apellido    = $('#apellido').val();
				let email       = $('#email').val();
				let telefono    = $('#telefono').val();
				let domicilio   = $('#domicilio').val();
				let contrasenia = $('#contrasenia').val();
				let repetircontrasenia = $('#repetircontrasenia').val();

				$.post('backend/procesar_cuenta.php',{nombre:nombre,apellido:apellido,email:email,telefono:telefono,domicilio:domicilio,contrasenia:contrasenia,repetircontrasenia:repetircontrasenia},function (resultado) {
						//alert(resultado);
						
						if ( resultado.error != null)
							alert(resultado.error);
						else{
							alert('Tus datos han sido actualizados correctamente!');
							location.href='index.php';
						}
				},'json')
			}



		})


	})


</script>
