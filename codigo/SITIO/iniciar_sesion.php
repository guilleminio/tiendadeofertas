<?php 
include('backend/configuracion.php');
?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo TITULO_SITIO;?> - Iniciar sesión</title>

	<?php include('modulos/librerias.php');?>
</head>
<body class="d-flex flex-column h-100">

	<?php include('encabezado.php');?>

	<div class="container contenedor">
		<div class="contenedorFormulario">

			<h1>INICIAR SESIÓN</h1>
			<div class="form">	
				<div>
					<div>
						<label for="email">Email:</label>
					</div>
					<div>
						<input class="form-control" type="email" id="email">
					</div>
				</div>
				
				<div>	
					<div>
						<label for="contrasenia">Contraseña:</label>
					</div>
					<div>
						<input class="form-control" type="password" id="contrasenia" maxlength="15">
					</div>
				</div>

				<div class="seccionCaptcha">
					<div>
						<img src="backend/captcha.php" alt="captcha" title="captcha">
					</div>
					<div>
						<input class="form-control" placeholder="Ingrese el texto de la imagen" type="text" id="captcha">
					</div>
				</div>
				
				<div class="divBoton">
					<button id="btnIngresar" class="btn btn-danger">INGRESAR</button>
				</div>	
			</div>

		</div>


		<div class="contenedorFormulario">

			<h1>CREAR CUENTA</h1>
			<div class="form">	
				<div>
					<div>
						<label for="emailReg">Email:</label>
					</div>
					<div>
						<input class="form-control" type="email" id="emailReg">
					</div>
				</div>
				
				<div>	
					<div>
						<label for="contraseniaReg">Contraseña:</label>
					</div>
					<div>
						<input class="form-control" type="password" id="contraseniaReg" maxlength="15">
					</div>
				</div>

				<div>	
					<div>
						<label for="contraseniaReg2">Repetir contraseña:</label>
					</div>
					<div>
						<input class="form-control" type="password" id="contraseniaReg2" maxlength="15">
					</div>
				</div>

				<div class="seccionCaptcha">

				</div>
				<div class="seccionCaptcha">
					
				</div>
				<div class="divBoton">
					<button id="btnRegistrar" class="btn btn-danger" >REGISTRARSE</button>
				</div>	
			</div>
			<div class="form-group">
	        	<p>*La contraseña debe contener entre 8 y 15 caracteres<br>
	        	   *Los campos son obligatorios</p>
	        </div>
			<div class="terminos">
				
				Al registrarse está aceptando los términos y condiciones
				
			</div>
		</div>
	</div>
	<?php include('pie.php');?>
</body>
</html>
<script type="text/javascript">

	$(document).ready(function() {
		
		function mostrarMensaje(data,input){
			alert(data);
			$('#'+input).focus();
		}

		function formularioInicioCompleto(){

			if ( $('#email').val().length == 0){
				mostrarMensaje('Debes indicar el email','email');
				return false;
			}

			if ( $('#contrasenia').val().length == 0){
				mostrarMensaje('Debes indicar una contrasenia','contrasenia');
				return false;
			}

			if ( $('#captcha').val().length == 0){
				mostrarMensaje('Debes ingresar el texto que se visualiza en la imagen','captcha');
				return false;
			}

			return true;
		}

		function formularioRegistroCompleto(){

			if ( $('#emailReg').val().length == 0){
				mostrarMensaje('Debes indicar el email','emailReg');
				return false;
			}

			if ( $('#contraseniaReg').val().length == 0){
				mostrarMensaje('Debes indicar una contrasenia','contraseniaReg');
				return false;
			}

			if($('#contraseniaReg').val().length < <?php echo CONTRASENIA_LONGITUD_MINIMA;?>){
 				mostrarMensaje('La longitud de la contraseña debe ser entre <?php echo CONTRASENIA_LONGITUD_MINIMA;?> y <?php echo CONTRASENIA_LONGITUD_MAXIMA;?> caracteres','contraseniaReg');
				return false;
			} 

			if ( $('#contraseniaReg2').val().length == 0){
				mostrarMensaje('Debes repetir la contraseña','contraseniaReg2');
				return false;
			}

			return true;
		}

		$('#btnIngresar').click(function(){

			if (formularioInicioCompleto()){

				let email       = $('#email').val();
				let contrasenia = $('#contrasenia').val();
				let captcha     = $('#captcha').val();

				$.post('backend/procesar_iniciarsesion.php',{email:email,contrasenia:contrasenia,captcha:captcha},function (resultado) {
						alert(resultado);
						
						if ( resultado.error != null)
							alert(resultado.error);
						else
							location.href=resultado.resultado;
				},'json')
			}

		})

		$('#btnRegistrar').click(function(){

			if ( formularioRegistroCompleto()){

				let email       = $('#emailReg').val();
				let contrasenia = $('#contraseniaReg').val();
				let repetircontrasenia = $('#contraseniaReg2').val();

				$.post('backend/procesar_registro_1.php',{email:email,contrasenia:contrasenia,repetircontrasenia:repetircontrasenia},function (resultado) {
						//alert(resultado);
						
						if ( resultado.error != null)
							alert(resultado.error);
						else
							location.href='registro.php';
				},'json')

			}

		})
	})

</script>