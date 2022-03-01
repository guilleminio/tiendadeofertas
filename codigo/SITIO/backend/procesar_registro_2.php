<?php
session_start();
include('funcionesBD.php');
include('configuracion.php');

$error     = null;
$resultado = null;

if (isset($_POST)){

	$usuario['nombre_usuario']      = strip_tags(addslashes($_POST['nombre']));
	$usuario['apellido_usuario']    = strip_tags(addslashes($_POST['apellido']));
	$usuario['telefono_usuario']    = strip_tags(addslashes($_POST['telefono']));
	$usuario['domicilio_usuario']   = strip_tags(addslashes($_POST['domicilio']));
	$usuario['fechaalta_usuario']   = date(FORMATO_FECHA_HORA);
	$usuario['ultimologin_usuario'] = date(FORMATO_FECHA_HORA);
	$usuario['offercrips']  	    = OFFERCRIPS_INICIAL;
	$usuario['email_usuario']       = $_SESSION['registro']['email'];
	$usuario['contrasenia_usuario'] = $_SESSION['registro']['contrasenia'];

	$conexion = conectarBD();

	if ( $conexion['resultado'] != null ){

			$nuevoUsuario = agregarUsuario($conexion['resultado'],$usuario);

			if ( $nuevoUsuario['resultado'] != null){

				$usuario['id_usuario'] = $nuevoUsuario['resultado'];
					
				$_SESSION['usuario_actual'] = $usuario;
				$_SESSION['usuario_actual']['pass'] = $_SESSION['registro']['pass'];
				unset($_SESSION['registro']);

				//CREO UN CARRO SIN INICAR SESIÓN?
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
					$resultado = 'Registro exitoso - Sin carro';
				}


			}else{
				$error = $nuevoUsuario['error'];
			}

	}else{
		$error = $conexion['error'];
	}

}else
 $error = "No se enviaron datos.";

 echo json_encode(array('resultado' => $resultado,'error' => $error));

?>