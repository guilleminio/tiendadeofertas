<?php
session_start();

include('funcionesBD.php');
include('configuracion.php');

$error = null;
$resultado = null;

if (isset($_POST)){

	$producto       = strip_tags(addslashes($_POST['producto']));
	$precio         = strip_tags(addslashes($_POST['precio']));
	$offercrips     = strip_tags(addslashes($_POST['offercrips']));
	$sumaoffercrips = strip_tags(addslashes($_POST['sumaoffercrips']));
	$cantidad       = strip_tags(addslashes($_POST['cantidad']));

	$usuario = null;
	if (isset($_SESSION['usuario_actual']))
		$usuario = $_SESSION['usuario_actual']['id_usuario'];
	
	$conexion = conectarBD();

	$totalItems = 0;
	if ( isset($_SESSION['carro'])){

		//OBTENGO LOS ÍTEMS DEL CARRO
		$totalItems = count($_SESSION['carro']['items']);
		$itemcarro = $_SESSION['carro']['items'];
	
		//AGREGO EL NUEVO ÍTEM
		$itemcarro[$totalItems]['id_producto'] = $producto;
		$itemcarro[$totalItems]['precio_unitario'] = $precio;
		$itemcarro[$totalItems]['cantidad'] = $cantidad;
		$itemcarro[$totalItems]['total_item'] = $cantidad*$precio;
		$itemcarro[$totalItems]['valor_offercrips'] = $offercrips;
		$itemcarro[$totalItems]['total_offercrips_item'] = $cantidad*$offercrips;
		$itemcarro[$totalItems]['suma_offercrips'] = $cantidad*$sumaoffercrips;


		$_SESSION['carro']['items'] = $itemcarro;

		//ACTUALIZO EL MONTO DEL CARRO (LOCAL)
		$totalItems = count($_SESSION['carro']['items']);

		$totalMontoCarro = 0;
		$totalOffercrips = 0;
		for ( $i = 0; $i < $totalItems; $i++){
			$totalMontoCarro += $_SESSION['carro']['items'][$i]['total_item'];
			$totalOffercrips += $_SESSION['carro']['items'][$i]['total_offercrips_item'];
		}

		$_SESSION['carro']['monto_carro'] = $totalMontoCarro;
		$_SESSION['carro']['offercrips_carro'] = $totalOffercrips;

		//SI HAY USUARIO CON SESIÓN, ENTONCES, SE ACTUALIZA EL CARRO EN LA BASE DE DATOS
		if ($usuario != null){

			if ( $conexion['resultado']!=null){

				$carroActualizado = null;
	
				$carroActualizado = modificarCarro($conexion['resultado'],$_SESSION['carro']);
			
				if ($carroActualizado['resultado'] != null ){
				
					$itemAgregado = agregarItemCarro($conexion['resultado'],$_SESSION['carro']['id_carro'],$totalItems-1,$_SESSION['carro']['items'][$totalItems-1]);
				
					if ( $itemAgregado['resultado'] != null )
						$resultado = $itemAgregado['resultado'];
					else
						$error = $itemAgregado['error'];

				}else{
					$error = $carroActualizado['error'];
				}

			}else{
				$error = $conexion['error'];
			}
		}else{
			$resultado = 'ok';
		}
		

	}else{

		//GENERO EL NUEVO CARRO
		$carro['fecha_carro'] = date('Y-m-d H:i:s');
		$carro['formapago_carro'] = null;
		$carro['formaenvio_carro'] = null;

		//AGREGO EL ÍTEM (EL CARRO SE GENERA CON UN SÓLO ÍTEM)
		$itemcarro[$totalItems]['id_producto'] = $producto;
		$itemcarro[$totalItems]['precio_unitario'] = $precio;
		$itemcarro[$totalItems]['cantidad'] = $cantidad;
		$itemcarro[$totalItems]['total_item'] = $cantidad*$precio;
		$itemcarro[$totalItems]['valor_offercrips'] = $offercrips;
		$itemcarro[$totalItems]['suma_offercrips'] = $cantidad*$sumaoffercrips;
		$itemcarro[$totalItems]['total_offercrips_item'] = $cantidad*$offercrips;

		$carro['items'] = $itemcarro;
		$carro['monto_carro'] = $itemcarro[$totalItems]['total_item'];
		$carro['offercrips_carro'] = /*$cantidad**/$itemcarro[$totalItems]['total_offercrips_item'];

		//SI HAY USUARIO CON SESIÓN, ENTONCES, SE INSERTA EL CARRO EN LA BASE DE DATOS
		if ( $usuario != null ){

			$nuevoCarro = null;
			$nuevoCarro = agregarCarro($conexion['resultado'],$usuario,$carro['fecha_carro'],$carro['monto_carro'],$carro['offercrips_carro']);

			$nuevoItem = null;
			if ( $nuevoCarro['resultado'] != null){

				$carro['id_carro'] = $nuevoCarro['resultado'];

				$nuevoItem = agregarItemCarro($conexion['resultado'],$nuevoCarro['resultado'],$totalItems,$carro['items'][$totalItems]);

				if ( $nuevoItem['resultado'] != null ){
					$resultado = $nuevoItem['resultado'];
				}else{
					$error = $nuevoItem['error'];
				}

			}else{
				$error = $nuevoCarro['error'];
			}

		}else{
			$resultado = 'Carro en sesion';
		}
		
		$_SESSION['carro'] = $carro;
	}

	
}else{
	$error = 'No se enviaron datos';
}

echo json_encode(array('resultado' => $resultado,'error' => $error));
?>