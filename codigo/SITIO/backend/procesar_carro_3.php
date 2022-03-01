<?php
session_start();
include('funcionesBD.php');

$error = null;
$resultado = null;


if ( isset($_POST) && isset($_SESSION['carro'])){

	$formaPago = strip_tags(addslashes($_POST['formaPago']));

	$_SESSION['carro']['formapago_carro'] = $formaPago;

	$conexion = conectarBD();

	if ( $conexion['resultado'] != null){

		$habilitado = true;
		//TIENE SALDO PARA PAGAR EL PEDIDO CON OFFERCRIPS?
		if ( ($formaPago == 2) && ($_SESSION['usuario_actual']['offercrips']<= $_SESSION['carro']['offercrips_carro'])){
			$habilitado = false;

		}

		if ($habilitado){

			$carroActualizado = modificarCarro($conexion['resultado'],$_SESSION['carro']);

			if ( $carroActualizado['resultado'] != null){
				$resultado = $carroActualizado['resultado'];
			}else{
				$error = $carroActualizado['error'];
			}

		}else{
			$error = "Atención!. No tienes saldo suficiente para abonar la compra.";
		}

	}else{
		$error = $conexion['error'];
	}


}else{
	$error = 'No se enviaron datos';
}

echo json_encode(array('resultado' => $resultado,'error' => $error));

?>