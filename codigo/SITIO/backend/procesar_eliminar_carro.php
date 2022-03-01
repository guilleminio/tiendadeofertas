<?php
session_start();
include('configuracion.php');
include('funcionesBD.php');

$error = null;
$resultado = null;

if ( isset($_SESSION['carro'])){

	//SI HAY SESIÓN INICIADA, ENTONCES HAY CARRO EN BASE DE DATOS
	if ( isset($_SESSION['usuario_actual'])){

		$conexion = conectarBD();

		if ( $conexion['resultado']){

			//SE ELIMINAN LOS ÍTEMS
			$itemsEliminados = eliminarItemsCarro($conexion['resultado'],$_SESSION['carro']['id_carro']);

			if ( $itemsEliminados['resultado'] != null ){

				$carroEliminado = eliminarCarro($conexion['resultado'],$_SESSION['carro']['id_carro']);

				if ( $carroEliminado['resultado'] != null ){
					$resultado = $carroEliminado['resultado'];
				}else{
					$error = $carroEliminado['error'];
				}

			}else{
				$error = $itemsEliminados['error'];
			}

		}else{
			$error = $conexion['error'];
		}
		
	}

	//ELIMINACION DEL CARRO (LOCAL)
	unset($_SESSION['carro']);


}else{
	$error = "No hay carro";
}

echo json_encode(array('resultado' => $resultado,'error' => $error));
?>