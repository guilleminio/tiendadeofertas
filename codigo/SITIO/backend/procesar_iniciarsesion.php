<?php
session_start();
include('configuracion.php');
include('funcionesBD.php');

$error = null;
$resultado = null;

if (isset($_POST)){

	$email        = strip_tags(addslashes($_POST['email']));
	$contrasenia  = strip_tags(addslashes($_POST['contrasenia']));
	$captcha      = strip_tags(addslashes($_POST['captcha']));


	if ($captcha == $_SESSION['captchaactual'] ){

		$conexion = conectarBD();

		if ( $conexion['resultado'] != null ){

			$usuario = iniciarSesion($conexion['resultado'],$email);
			
			if ( ($usuario['resultado'] != null) ){
	
				if (password_verify($contrasenia, $usuario['resultado']['contrasenia_usuario']) ){

					$resultado = 'ok';
					$_SESSION['usuario_actual'] = $usuario['resultado'];
					$_SESSION['usuario_actual']['pass'] = $contrasenia;
					$_SESSION['usuario_actual']['ultimologin_usuario'] = date(FORMATO_FECHA_HORA);

					modificarUsuario($conexion['resultado'],$_SESSION['usuario_actual']);

					//TIENE CARRO?
					$carro = obtenerCarro($conexion['resultado'],$_SESSION['usuario_actual']['id_usuario']);
					
					if ( ($carro['resultado']!=null) && ($carro['error']==null)){
						//EL USUARIO TIENE CARRO
						//OBTENGO LOS ÍTEMS
						$itemsCarro = obtenerItemsCarro($conexion['resultado'],$carro['resultado']['id_carro']);

						if ( $itemsCarro['resultado'] != null){

							//CREO UN CARRO SIN INICIAR SESIÓN?
							if ( isset($_SESSION['carro'])){

								//HAY QUE ACTUALIZAR EL CARRO
								$carro['resultado']['monto_carro']+=$_SESSION['carro']['monto_carro'];
								$carro['resultado']['offercrips_carro']+=$_SESSION['carro']['offercrips_carro'];

/*
								$carroActualizado = modificarCarro($conexion['resultado'],$_SESSION['carro']);
*/
								$carroActualizado = modificarCarro($conexion['resultado'],$carro['resultado']);


								if ( $carroActualizado['resultado'] != null){

									//SE AGREGAN LOS ÍTEMS
									$totalNuevosItems = count($_SESSION['carro']['items']);
									$totalItems = count($itemsCarro['resultado']);
									
									$items = agregarVariosItemsCarro($conexion['resultado'],$carro['resultado']['id_carro'],$totalItems,$totalNuevosItems,$_SESSION['carro']['items']);


									if ( $items['resultado'] != null){
										
										$itemsCarro = obtenerItemsCarro($conexion['resultado'],$carro['resultado']['id_carro']);
										$carroActualizado = obtenerCarro($conexion['resultado'],$_SESSION['usuario_actual']['id_usuario']);

										$_SESSION['carro'] = $carroActualizado['resultado'];

										$_SESSION['carro']['items'] = $itemsCarro['resultado'];

										$resultado = $items['resultado'];

									}else{
										$error = $items['error'];
									}


								}else{
									$error = $carroActualizado['error'];
								}
							}else{
								//NO CREO CARRO SIN INICIAR SESIÓN
								$resultado = 'ok';
								$_SESSION['carro'] = $carro['resultado'];
								$_SESSION['carro']['items'] = $itemsCarro['resultado'];
							}

						}else{
							$error = $itemsCarro['error'];
						}

					}else{

						//EL USUARIO NO TIENE CARRO
						//CREÓ UN CARRO SIN INICIAR SESIÓN?
						if ( isset($_SESSION['carro'])){

							//HAY QUE INSERTAR EL CARRO EN LA BASE DE DATOS
							$nuevoCarro = agregarCarro($conexion['resultado'],$_SESSION['usuario_actual']['id_usuario'],$_SESSION['carro']['fecha_carro'],$_SESSION['carro']['monto_carro'],$_SESSION['carro']['offercrips_carro']);

							if ( $nuevoCarro['resultado'] != null){
								//SE AGREGAN LOS ÍTEMS
								$totalItems = count($_SESSION['carro']['items']);
								
								$items = agregarVariosItemsCarro($conexion['resultado'],$nuevoCarro['resultado'],0,$totalItems,$_SESSION['carro']['items']);


								if ( $items['resultado'] != null){
									$resultado = $items['resultado'];
									$_SESSION['carro']['id_carro'] = $nuevoCarro['resultado'];
								}else{
									$error = $items['error'];
								}

							}else{
								$error = $nuevoCarro['error'];
							}

						}else{
							$resultado = 'ok';
						}
					}
						

					if (isset($_SESSION['pagina_actual'])){
						$resultado = $_SESSION['pagina_actual'];
					}else{
						$resultado = 'index.php';
					}
					

				}else{
						//CONTRASEÑA INCORRECTA
					$error = 'Usuario y/o contrasenia incorrectos';
				}
				
			}else{

				$error = $usuario['error'];//'Usuario y/o contrasenia incorrectos';
			}

		}else{
			$error = $conexion['error'];
		}


	}else{
		$error = 'Captcha incorrecto';
	}

}else{
	 $error = "No se enviaron datos.";
}


 echo json_encode(array('resultado' => $resultado,'error' => $error));


?>