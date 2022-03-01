<?php
session_start();

include('funcionesBD.php');

if ( isset($_SESSION['usuario_actual']) && isset($_SESSION['carro'])){

	$conexion = conectarBD();

	$resultado = null;
	$error = null;
	if ( $conexion['resultado'] != null ){	

		//CREO EL PEDIDO
		$pedido['id_usuario'] = $_SESSION['usuario_actual']['id_usuario'];
		$pedido['fecha_pedido'] = date('Y-m-d H:i:s');

		switch ($_SESSION['carro']['formapago_carro']) {
			case 1: //EFECTIVO
				$pedido['estado_pedido'] = 4;
				break;
			default: //OFFECRIPS
				$pedido['estado_pedido'] = 1;
				//ACTUALIZO EL SALDO DEL USUARIO
				$_SESSION['usuario_actual']['offercrips']-= $_SESSION['carro']['offercrips_carro'];
				break;
		}

		$pedido['monto_pedido'] = $_SESSION['carro']['monto_carro'];
		$pedido['formapago_pedido'] = $_SESSION['carro']['formapago_carro'];
		$pedido['formaenvio_pedido'] = $_SESSION['carro']['formaenvio_carro'];
		$pedido['offercrips_pedido'] = $_SESSION['carro']['offercrips_carro'];

		$nuevoPedido = agregarPedido($conexion['resultado'],$pedido);

		if ( $nuevoPedido['resultado'] != null){

			$_SESSION['orden_pedido'] = $nuevoPedido['resultado'];

			//CALCULO EL BENEFICIO DE OFFERCRIPS
			$totalItems = count($_SESSION['carro']['items']);

			$beneficio = 0;
			for ( $i=0;$i < $totalItems; $i++){
				$beneficio+= $_SESSION['carro']['items'][$i]['suma_offercrips'];
			}

			$_SESSION['usuario_actual']['offercrips'] += $beneficio;

			modificarUsuario($conexion['resultado'],$_SESSION['usuario_actual']);

			//AGREGO LOS ITEMS DEL PEDIDO
			$items = agregarItemsPedido($conexion['resultado'],$nuevoPedido['resultado'],$_SESSION['carro']['items']);

			if ( $items['resultado'] != null ){
			
				$resultado = $items['resultado'];

				//HAY QUE ELIMINAR EL CARRO Y LOS ITEMS
				$itemsEliminados = eliminarItemsCarro($conexion['resultado'],$_SESSION['carro']['id_carro']);

				if ( $itemsEliminados['resultado'] != null ){

					$carroEliminado = eliminarCarro($conexion['resultado'],$_SESSION['carro']['id_carro']);

					if ( $carroEliminado['resultado'] != null){
						$resultado = $carroEliminado['resultado'];
						unset($_SESSION['carro']);

					}else{
						$error = $carroEliminado['error'];
					}

				}else{
					$error = $itemsEliminados['error'];
				}

			}else{
				$error = $items['error'];
			}

		}else{
			$error = $nuevoPedido['error'];
		}

	}else{
		$error = $conexion['error'];
	}
}
else{
	$error = 'USUARIO NO AUTORIZADO';
	header('Location: index.php');
	exit();
}
echo json_encode(array('resultado' => $resultado,'error' => $error));
?>