<?php
session_start();
include('funcionesBD.php');
include('configuracion.php');

$error = null;
$resultado = null;

if (isset($_POST)){

	$usuario['id_usuario']          = $_SESSION['usuario_actual']['id_usuario'];
	$usuario['nombre_usuario']      = strip_tags(addslashes($_POST['nombre']));
	$usuario['apellido_usuario']   	= strip_tags(addslashes($_POST['apellido']));
	$usuario['email_usuario']       = strip_tags(addslashes($_POST['email']));
	$usuario['telefono_usuario']    = strip_tags(addslashes($_POST['telefono']));
	$usuario['domicilio_usuario']   = strip_tags(addslashes($_POST['domicilio']));
	$usuario['fechaalta_usuario']   = $_SESSION['usuario_actual']['fechaalta_usuario'];
	$usuario['ultimologin_usuario'] = $_SESSION['usuario_actual']['ultimologin_usuario'];
	$usuario['offercrips']          = $_SESSION['usuario_actual']['offercrips'];

	$contrasenia = strip_tags(addslashes($_POST['contrasenia']));
	$repetircontrasenia = strip_tags(addslashes($_POST['repetircontrasenia']));

	if (strcmp($contrasenia,$repetircontrasenia) == 0){

		$conexion = conectarBD();

		if ( $conexion['resultado'] != null ){

				$usuario['contrasenia_usuario'] = password_hash($contrasenia, PASSWORD_DEFAULT);

				$usuarioActualizado = modificarUsuario($conexion['resultado'],$usuario);

				if ( $usuarioActualizado['resultado'] != null){

					$resultado = 'ok';

					$_SESSION['usuario_actual'] = $usuario;
					$_SESSION['usuario_actual']['pass'] = $contrasenia;

				}else{
					$error = $usuarioActualizado['error'];
				}

		}else{
			$error = $conexion['error'];
		}

	}else{
		$error = "Las contraseñas no coinciden";
	}

}else
 $error = "No se enviaron datos.";

 echo json_encode(array('resultado' => $resultado,'error' => $error));


?>