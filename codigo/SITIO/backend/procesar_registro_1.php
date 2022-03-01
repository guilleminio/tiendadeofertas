<?php
session_start();
include('funcionesBD.php');

$error = null;
$resultado = null;

if (isset($_POST)){
	
	$email              = strip_tags(addslashes($_POST['email']));
	$contrasenia 		= strip_tags(addslashes($_POST['contrasenia']));
	$repetircontrasenia = strip_tags(addslashes($_POST['repetircontrasenia']));

	if (strcmp($contrasenia,$repetircontrasenia) == 0){

		$conexion = conectarBD();

		if ( $conexion['resultado'] != null){

			$usuarioExistente = existeUsuario($conexion['resultado'],$email);

			if ( $usuarioExistente['resultado'] != null){

				$registro['email'] = $email;
				$registro['pass']  = $contrasenia;
				$registro['contrasenia'] = password_hash($contrasenia, PASSWORD_DEFAULT);

				$_SESSION['registro'] = $registro;

				$resultado = 'ok';

			}else{
				$error = $usuarioExistente['error'];
			}
		}else{
			$error = $conexion['error'];
		}


	}else{
		$error = "Las contraseñas no coinciden";
	}

}else{
	 $error = "No se enviaron datos.";
}

 echo json_encode(array('resultado' => $resultado,'error' => $error));

?>