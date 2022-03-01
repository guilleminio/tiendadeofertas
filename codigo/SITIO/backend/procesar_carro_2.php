<?php
session_start();
include('funcionesBD.php');

$error = null;
$resultado = null;


if ( isset($_POST) && isset($_SESSION['carro'])){

	$formaEntrega = strip_tags(addslashes($_POST['formaEnvio']));

	$_SESSION['carro']['formaenvio_carro'] = $formaEntrega;
	
	$conexion = conectarBD();

	if ( $conexion['resultado'] != null){

		$carroActualizado = modificarCarro($conexion['resultado'],$_SESSION['carro']);

		if ( $carroActualizado['resultado'] != null){
			$resultado = $carroActualizado['resultado'];
		}else{
			$error = $carroActualizado['error'];
		}

	}else{
		$error = $conexion['error'];
	}


}else{
	$error = 'No se enviaron datos';
}

echo json_encode(array('resultado' => $resultado,'error' => $error));

?>