<?php
session_start();
include('funcionesBD.php');

$error = null;
$resultado = null;

if ( isset($_POST)){

	$item = strip_tags(addslashes($_POST['item']));

	//HAY QUE ACTUALIZAR EL CARRO
	$_SESSION['carro']['monto_carro'] -= $_SESSION['carro']['items'][$item]['total_item'];
	$_SESSION['carro']['offercrips_carro'] -= $_SESSION['carro']['items'][$item]['total_offercrips_item'];
	
	array_splice($_SESSION['carro']['items'], $item, 1);
	$totalItems = count($_SESSION['carro']['items']);
	$vaciarCarro = false;

	if ($totalItems == 0)
		$vaciarCarro = true;


	if ( isset($_SESSION['usuario_actual'])){
		//SE ELIMINA EN LA BASE DE DATOS
		$item++; //Porque en BD comienza con 1	

		$conexion = conectarBD();

		if ( $conexion['resultado'] != null ){

			$itemEliminado = eliminarItemCarro($conexion['resultado'],$_SESSION['carro']['id_carro'],$item);

			if ( $itemEliminado['resultado'] != null){

				$carroActualizado = null;
				if ($vaciarCarro){
					
					$carroActualizado = eliminarCarro($conexion['resultado'],$_SESSION['carro']);

					if ( $carroActualizado['resultado'] !=null ){
						$resultado = 'ok';
					}else{
						$error = $carroActualizado['error'];
					}

				}else{

					$carroActualizado = modificarCarro($conexion['resultado'],$_SESSION['carro']);

					if ( $carroActualizado['resultado'] != null){

						$resultado = 'ok';
						
					}else{
						$error = $carroActualizado['error'];
					}

				}
				
			}else{
				$error = $itemEliminado['error'];
			}

		}else{
			$error = $conexion['error'];
		}
	}

	if ($vaciarCarro)
		unset($_SESSION['carro']);

}else{
	$error = "No se enviaron datos.";
}

echo json_encode(array('resultado' => $resultado,'error' => $error));
?>