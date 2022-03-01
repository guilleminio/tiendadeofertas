<?php 
/*=============================================
ARCHIVO : funcionesBD.php
CONTENIDO: funciones para consulta a la base de
		   datos (INSERT-SELECT-UPDATE-DELETE)
===============================================*/

function conectarBD(){

	$conexion = new mysqli('localhost','root','','tienda_de_ofertas');

	$resultado = null;
	$error = null;

	if ( $conexion->connect_error)
		$error = "Problemas al conectar con la base de datos: ".$conexion->connect_error;
	else
		$resultado = $conexion;

	return array('resultado'=> $resultado,'error'=>$error);
}

/*--------------------------------------------------------------------------------
USUARIO
--------------------------------------------------------------------------------
*/
function existeUsuario($conexion,$email){

	$sentencia = $conexion->prepare("SELECT id_usuario FROM usuario WHERE email_usuario = ?");

	$resultado = null;
	$error = null;
	if ($sentencia){

		if ( $sentencia->bind_param('s',$email)){

			if ( $sentencia->execute()){
				
				$fila = $sentencia->get_result();

				if ( $fila->num_rows > 0)
					$error = "Ya existe un usuario registrado con ese email.";
				else
					$resultado = "ok";
				$sentencia->close();

			}else{
				$error = "E - Problemas al consultar el usuario. ".$sentencia->error;
			}

		}else{
			$error = "B - Problemas al consultar el usuario. ".$sentencia->error;
		}
	}else{
		$error = "P - Problemas al consultar el usuario. ".$conexion->error;
	}

	return array('resultado'=> $resultado,'error'=>$error);
}

function obtenerUsuario($conexion,$id){

	$sentencia = $conexion->prepare("SELECT * FROM usuario WHERE id_usuario = ?");

	$resultado = null;
	$error = null;
	if ($sentencia){
		if ( $sentencia->bind_param('i',$id)){

			if ( $sentencia->execute()){
				
				$usuario = $sentencia->get_result();
				$resultado = $usuario->fetch_assoc();
				$sentencia->close();

			}else{
				$error = "E - Problemas al obtener el usuario. ".$sentencia->error;
			}

		}else{
			$error = "B - Problemas al obtener el usuario. ".$sentencia->error;;
		}
	}else{
		$error = "P Problemas al obtener el usuario. ".$conexion->error;;
	}

	return array('resultado'=> $resultado,'error'=>$error);
}

function agregarUsuario($conexion,$usuario){

	$sentencia = $conexion->prepare('INSERT INTO usuario(nombre_usuario,apellido_usuario,email_usuario,contrasenia_usuario,domicilio_usuario,telefono_usuario,fechaalta_usuario,ultimologin_usuario,offercrips)VALUES(?,?,?,?,?,?,?,?,?)');

	$resultado = null;
	$error = null;
	if ($sentencia){
		if ( $sentencia->bind_param('ssssssssd',$usuario['nombre_usuario'],$usuario['apellido_usuario'],$usuario['email_usuario'],$usuario['contrasenia_usuario'],$usuario['domicilio_usuario'],$usuario['telefono_usuario'],$usuario['fechaalta_usuario'],$usuario['ultimologin_usuario'],$usuario['offercrips'],)){

			if ( $sentencia->execute()){
				
				$resultado = $conexion->insert_id;
				$sentencia->close();

			}else{
				$error = "E - Problemas al agregar el usuario. ".$sentencia->error;
			}

		}else{
			$error = "B - Problemas al agregar el usuario. ".$sentencia->error;
		}
	}else{
		$error = "P - Problemas al agregar el usuario. ".$conexion->error;
	}

	return array('resultado'=> $resultado,'error'=>$error);
}

function modificarUsuario($conexion/*,$id*/,$usuario){

	$sentencia = $conexion->prepare('UPDATE usuario SET nombre_usuario = ?,apellido_usuario = ?,email_usuario = ?,contrasenia_usuario = ?, domicilio_usuario = ?, telefono_usuario = ?, ultimologin_usuario = ?,offercrips = ? WHERE id_usuario=?');

	$resultado = null;
	$error = null;
	if ($sentencia){
		if ( $sentencia->bind_param('sssssssdi',$usuario['nombre_usuario'],$usuario['apellido_usuario'],$usuario['email_usuario'],$usuario['contrasenia_usuario'],$usuario['domicilio_usuario'],$usuario['telefono_usuario'],$usuario['ultimologin_usuario'],$usuario['offercrips'],$usuario['id_usuario'])){

			if ( $sentencia->execute()){
				
				$resultado = 'ok';
				$sentencia->close();

			}else{
				$error = "E - Problemas al actualizar los datos del usuario. ".$sentencia->error;
			}

		}else{
			$error = "B - Problemas al actualizar los datos del usuario. ".$sentencia->error;
		}
	}else{
		$error = "P - Problemas al actualizar los datos del usuario. ".$conexion->error;
	}

	return array('resultado'=> $resultado,'error'=>$error);

}

/*--------------------------------------------------------------------------------
INICIAR SESIÓN
--------------------------------------------------------------------------------
*/
function iniciarSesion($conexion,$email){


	$sentencia = $conexion->prepare('SELECT * FROM usuario WHERE email_usuario = ?');

	$error = null;
	$resultado = null;

	if ( $sentencia ){

		if ( $sentencia->bind_param('s',$email)){

			if ( $sentencia->execute()){

				$usuario = $sentencia->get_result();
				$resultado = $usuario->fetch_assoc();
				$sentencia->close();
			}else{
				$error = 'E - Problemas al iniciar sesión: '.$sentencia->error;
			}

		}else{
			$error = 'B - Problemas al iniciar sesión: '.$sentencia->error;	
		}

	}else{
		$error = 'P - Problemas al iniciar sesión: '.$conexion->error;
	}

	return array('resultado'=> $resultado,'error'=>$error);

}
/*--------------------------------------------------------------------------------
CARRO
--------------------------------------------------------------------------------
*/

function obtenerCarro($conexion,$usuario){

	$sentencia = $conexion->prepare('SELECT * FROM carro WHERE id_usuario = ?');

	$error = null;
	$resultado = null;

	if ( $sentencia ){

		if ( $sentencia->bind_param('i',$usuario)){

			if ( $sentencia->execute()){

				$carro = $sentencia->get_result();
				$resultado = $carro->fetch_assoc();
				$sentencia->close();

			}else{
				$error = 'E - Problemas al obtener el carro. '.$sentencia->error;
			}

		}else{
			$error = 'B - Problemas al obtener el carro. '.$sentencia->error;
		}

	}else{

		$error = 'P - Problemas al obtener el carro. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);

}

function obtenerItemsCarro($conexion,$carro){

	$sentencia = $conexion->prepare('SELECT * FROM item_carro WHERE id_carro=?');

	$error = null;
	$resultado = null;

	if ( $sentencia ){

		if ( $sentencia->bind_param('i',$carro)){

			if ( $sentencia->execute()){

				$items = $sentencia->get_result();
				$resultado = $items->fetch_all(MYSQLI_ASSOC);
				$sentencia->close();

			}else{
				$error = 'E - Problemas al obtener los items del carro. '.$sentencia->error;
			}

		}else{
			$error = 'B - Problemas al obtener los items del carro. '.$sentencia->error;
		}

	}else{

		$error = 'P - Problemas al obtener los items del carro. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);

}

function agregarCarro($conexion,$usuario,$fecha,$monto,$offercrips){

	$sentencia = $conexion->prepare('INSERT INTO carro(id_usuario,fecha_carro,estado_carro,monto_carro,offercrips_carro)VALUES(?,?,?,?,?)');

	$resultado = null;
	$error = null;
	if ( $sentencia ){

		$estado = 1;
		if ( $sentencia->bind_param('isidd',$usuario,$fecha,$estado,$monto,$offercrips)){

			if ( $sentencia->execute())
			{
				$resultado = $conexion->insert_id;
				$sentencia->close();

			}else{
				$erro = 'E - Problemas al agregar el carro. '.$sentencia->error;
			}

		}else{
			$error = 'B - Problemas al agregar el carro. '.$sentencia->error;
		}

	}else{
		$error = 'P - Problemas al agregar el carro. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);
}

function agregarItemCarro($conexion,$carro,$id_item,$item){

	$sentencia = $conexion->prepare('INSERT INTO item_carro(id_item,id_carro,id_producto,precio_unitario,valor_offercrips,cantidad,total_item,total_offercrips_item,suma_offercrips)VALUES(?,?,?,?,?,?,?,?,?)');

	$resultado = null;
	$error = null;
	if ( $sentencia ){
		
		$id = $id_item+1;
		if ( $sentencia->bind_param('iiiddiddd',$id,$carro,$item['id_producto'],$item['precio_unitario'],$item['valor_offercrips'],$item['cantidad'],$item['total_item'],$item['total_offercrips_item'],$item['suma_offercrips'])){

			if ( $sentencia->execute()){

				$resultado = 'ok';
				$sentencia->close();

			}else{
				$error = ' E - Problemas al agregar los ítems al carro. '.$sentencia->error;
			}


		}else{
			$error = 'B - Problemas al agregar los items.'.$sentencia->error;
		}


	}else{
		$error = 'P - Problemas al agregar los items al carro. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);
}

function agregarVariosItemsCarro($conexion,$idcarro,$totalItems,$totalNuevosItems,$items){

	$sentencia = $conexion->prepare('INSERT INTO item_carro(id_item,id_carro,id_producto,precio_unitario,valor_offercrips,cantidad,total_item,total_offercrips_item,suma_offercrips)VALUES(?,?,?,?,?,?,?,?,?)');

	$resultado = null;
	$error = null;
	if ( $sentencia ){
		$totalItems++;
		$id = $totalItems;
		$idcarro = $idcarro;
		$producto = $items[0]['id_producto'];
		$preciounitario = $items[0]['precio_unitario'];
		$valoroffer = $items[0]['valor_offercrips'];
		$cantidad = $items[0]['cantidad'];
		$total = $items[0]['total_item'];  
		$totalOffer = $items[0]['total_offercrips_item'];
		$sumaoffer = $items[0]['suma_offercrips'];

		if ( $sentencia->bind_param('iiiddiddd',$id,$idcarro,$producto,$preciounitario,$valoroffer,$cantidad,$total,$totalOffer,$sumaoffer)){

			if ( $sentencia->execute()){

				$totalItems++;
				$fallo = false;
				for ($i=1; $i < $totalNuevosItems; $i++){
					
					$id = $totalItems;
					$producto = $items[$i]['id_producto'];
					$preciounitario = $items[$i]['precio_unitario'];
					$valoroffer = $items[$i]['valor_offercrips'];
					$cantidad = $items[$i]['cantidad'];
					$total = $items[$i]['total_item'];
					$totalOffer = $items[$i]['total_offercrips_item'];
					$sumaoffer = $items[$i]['suma_offercrips'];

					$sentencia->execute();
					if (!$sentencia){
						$error = 'EM - Problemas al agregar items al carro. '.$sentencia->error;
						$fallo = true;
						break;
					}
					$totalItems++;
				}

				if ( !$fallo ){
					$resultado = 'ok';
					$sentencia->close();
				}
			}else{
				$error = ' E - Problemas al agregar los ítems al carro. '.$sentencia->error;
			}


		}else{
			$error = 'B - Problemas al agregar los items.'.$sentencia->error;
		}


	}else{
		$error = 'P - Problemas al agregar los items al carro. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);

}

function eliminarItemCarro($conexion,$carro,$item){

	$sentencia = $conexion->prepare('DELETE FROM item_carro WHERE id_carro = ? AND id_item = ?');

	$error = null;
	$resultado = null;

	if ( $sentencia ){

		if ( $sentencia->bind_param('ii',$carro,$item)){

			if ( $sentencia->execute()){

				$resultado = 'ok';
				$sentencia->close();

			}else{
				$error = 'E - Problemas al eliminar item del carro. '.$sentencia->error;
			}


		}else{
			$error = 'B - Problemas al eliminar item del carro. '.$sentencia->error;
		}

	}else{

		$error = 'P - Problemas al eliminar item del carro. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);

}

function eliminarItemsCarro($conexion,$carro){

	$sentencia = $conexion->prepare('DELETE FROM item_carro WHERE id_carro = ?');

	$error = null;
	$resultado = null;

	if ( $sentencia ){

		if ( $sentencia->bind_param('i',$carro)){

			if ( $sentencia->execute()){

				$resultado = 'ok';
				$sentencia->close();

			}else{
				$error = 'E - Problemas al eliminar los items del carro. '.$sentencia->error;
			}


		}else{
			$error = 'B - Problemas al eliminar los items del carro. '.$sentencia->error;
		}

	}else{

		$error = 'P - Problemas al eliminar los items del carro. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);

}

function modificarCarro($conexion,$carro){

	$sentencia = $conexion->prepare('UPDATE carro SET monto_carro = ?, offercrips_carro = ?, formapago_carro = ?, formaenvio_carro = ? WHERE id_carro = ?');

	$error = null;
	$resultado = null;
	if ( $sentencia ){

		if ( $sentencia->bind_param('ddiii',$carro['monto_carro'],$carro['offercrips_carro'],$carro['formapago_carro'],$carro['formaenvio_carro'],$carro['id_carro'])){

			if ( $sentencia->execute()){

				$resultado = 'ok';
				$sentencia->close();

			}else{
				$error = 'E - Problemas al actualizar el carro. '.$sentencia->error;
			}

		}else{
			$error = 'B - Problemas al actualizar el carro. '.$sentencia->error;
		}

	}else{
		$error = 'P - Problemas al actualizar el carro. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);
}

function eliminarCarro($conexion,$carro){

	$sentencia = $conexion->prepare('DELETE FROM carro WHERE id_carro = ?');

	$error = null;
	$resultado = null;

	if ( $sentencia ){

		if ( $sentencia->bind_param('i',$carro)){

			if ( $sentencia->execute()){

				$resultado = 'ok';
				$sentencia->close();

			}else{
				$error = 'E - Problemas al eliminar el carro. '.$sentencia->error;
			}


		}else{
			$error = 'B - Problemas al eliminar el carro. '.$sentencia->error;
		}

	}else{

		$error = 'P - Problemas al eliminar el carro. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);


}

/*--------------------------------------------------------------------------------
FORMAS DE PAGO - FORMAS DE ENTREGA
--------------------------------------------------------------------------------
*/
function obtenerFormaPago($conexion,$idformapago){

	$sentencia = $conexion->prepare('SELECT * FROM forma_pago WHERE id_formapago = ?');

	$error = null;
	$resultado = null;

	if ( $sentencia ){

		if ( $sentencia->bind_param('i',$idformapago)){

			if ( $sentencia->execute()){

				$item = $sentencia->get_result();
				$resultado = $item->fetch_assoc();
				$sentencia->close();

			}else{
				$error = 'E - Problemas al obtener la formas de pago. '.$sentencia->error;
			}


		}else{
			$error = 'B - Problemas al obtener la forma de pago. '.$sentencia->error;
		}

	}else{

		$error = 'P - Problemas al obtener la formas de pago. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);

}

function obtenerFormasPago($conexion){

	$sentencia = $conexion->prepare('SELECT * FROM forma_pago');

	$error = null;
	$resultado = null;

	if ( $sentencia ){

			if ( $sentencia->execute()){

				$items = $sentencia->get_result();
				$resultado = $items->fetch_all(MYSQLI_ASSOC);
				$sentencia->close();

			}else{
				$error = 'E - Problemas al obtener las formas de pago. '.$sentencia->error;
			}

	}else{

		$error = 'P - Problemas al obtener las formas de pago. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);

}

function obtenerFormaEntrega($conexion,$idformaentrega){

	$sentencia = $conexion->prepare('SELECT * FROM forma_envio WHERE id_formaenvio = ?');

	$error = null;
	$resultado = null;

	if ( $sentencia ){

		if ( $sentencia->bind_param('i',$idformaentrega)){

			if ( $sentencia->execute()){

				$item = $sentencia->get_result();
				$resultado = $item->fetch_assoc();
				$sentencia->close();

			}else{
				$error = 'E - Problemas al obtener la formas de envio. '.$sentencia->error;
			}


		}else{
			$error = 'B - Problemas al obtener la forma de envio. '.$sentencia->error;
		}

	}else{

		$error = 'P - Problemas al obtener la formas de envio. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);

}

function obtenerFormasEntrega($conexion){

	$sentencia = $conexion->prepare('SELECT * FROM forma_envio');

	$error = null;
	$resultado = null;

	if ( $sentencia ){

			if ( $sentencia->execute()){

				$items = $sentencia->get_result();
				$resultado = $items->fetch_all(MYSQLI_ASSOC);
				$sentencia->close();

			}else{
				$error = 'E - Problemas al obtener las formas de entrega. '.$sentencia->error;
			}

	}else{

		$error = 'P - Problemas al obtener las formas de entrega. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);
}

/*--------------------------------------------------------------------------------
PEDIDO
--------------------------------------------------------------------------------
*/
function agregarPedido($conexion,$pedido){

	$sentencia = $conexion->prepare('INSERT INTO pedido(id_usuario,fecha_pedido,estado_pedido,monto_pedido,offercrips_pedido,formapago_pedido,formaenvio_pedido)VALUES(?,?,?,?,?,?,?)');

	$error = null;
	$resultado = null;

	if ($sentencia){

		if ($sentencia->bind_param('isiddii',$pedido['id_usuario'],$pedido['fecha_pedido'],$pedido['estado_pedido'],$pedido['monto_pedido'],$pedido['offercrips_pedido'],$pedido['formapago_pedido'],$pedido['formaenvio_pedido'])){

			if ( $sentencia->execute()){

				$resultado = $conexion->insert_id;
				$sentencia->close();

			}else{
				$error = 'E - Problemas al agregar el pedido. '.$sentencia->error;
			}

		}else{
			$error = 'P - Problemas al agregar el pedido. '.$sentencia->error;
		}

	}else{
		$error = 'P - Problemas al agregar el pedido. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);
}

function agregarItemsPedido($conexion,$pedido,$items){

	$sentencia = $conexion->prepare('INSERT INTO item_pedido(id_pedido,id_item,id_producto,precio_unitario_item,valor_offercrips,cantidad_item,precio_total_item,total_offercrips_item,suma_offercrips)VALUES(?,?,?,?,?,?,?,?,?)');

	$resultado = null;
	$error = null;
	if ( $sentencia ){
		
		$totalItems = count($items);
		$iditem = 1;
		$idpedido = $pedido;
		$producto = $items[0]['id_producto'];
		$precio = $items[0]['precio_unitario'];
		$valoroffer = $items[0]['valor_offercrips'];
		$cantidad = $items[0]['cantidad'];
		$total = $items[0]['total_item'];
		$sumaoffer = $items[0]['suma_offercrips'];
		$totalOffer = $items[0]['total_offercrips_item'];

		if ( $sentencia->bind_param('iiiddiddd',$idpedido,$iditem,$producto,$precio,$valoroffer,$cantidad,$total,$totalOffer,$sumaoffer)){

			if ( $sentencia->execute()){

				$fallo = false;
				for ($i=1; $i < $totalItems; $i++){
					
					$iditem++;
					$producto = $items[$i]['id_producto'];
					$precio = $items[$i]['precio_unitario'];
					$valoroffer = $items[$i]['valor_offercrips'];
					$cantidad = $items[$i]['cantidad'];
					$total = $items[$i]['total_item'];
					$sumaoffer = $items[$i]['suma_offercrips'];
					$totalOffer = $items[$i]['total_offercrips_item'];

					$sentencia->execute();
					if (!$sentencia){
						$error = 'EM - Problemas al agregar items al pedido. '.$sentencia->error;
						$fallo = true;
						break;
					}
				}

				if ( !$fallo ){
					$resultado = 'ok';
					$sentencia->close();
				}

			}else{
				$error = ' E - Problemas al agregar los ítems al pedido. '.$sentencia->error;
			}


		}else{
			$error = 'B - Problemas al agregar los pedido.'.$sentencia->error;
		}


	}else{
		$error = 'P - Problemas al agregar los items al pedido. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);

}

function obtenerPedido($conexion,$idpedido)
{
	$sentencia = $conexion->prepare('SELECT * FROM pedido WHERE id_pedido = ?');

	$error = null;
	$resultado = null;

	if ( $sentencia ){

		if ( $sentencia->bind_param('i',$idpedido)){

			if ( $sentencia->execute()){

				$items = $sentencia->get_result();
				$resultado = $items->fetch_assoc();
				$sentencia->close();

			}else{
				$error = 'P - Problemas al obtener pedido. '.$sentencia->error;
			}

		}else{
			$error = 'P - Problemas al obtener pedido. '.$sentencia->error;
		}

	}else{
		$error = 'P - Problemas al obtener pedido. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);
}

function obtenerPedidos($conexion,$idusuario){

	$sentencia = $conexion->prepare('SELECT * FROM pedido WHERE id_usuario = ?');

	$error = null;
	$resultado = null;

	if ( $sentencia ){

		if ( $sentencia->bind_param('i',$idusuario)){

			if ( $sentencia->execute()){

				$items = $sentencia->get_result();
				$resultado = $items->fetch_all(MYSQLI_ASSOC);
				$sentencia->close();

			}else{
				$error = 'P - Problemas al obtener los pedidos. '.$sentencia->error;
			}

		}else{
			$error = 'P - Problemas al obtener los pedidos. '.$sentencia->error;
		}

	}else{
		$error = 'P - Problemas al obtener los pedidos. '.$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);
}

function obtenerItemsPedido($conexion,$idpedido){

	$sentencia = $conexion->prepare('SELECT * FROM item_pedido WHERE id_pedido = ?');

	$error = null;
	$resultado = null;
	if ( $sentencia ){

		if ( $sentencia->bind_param('i',$idpedido)){

			if ( $sentencia->execute()){
			
				$items     = $sentencia->get_result();
				$resultado = $items->fetch_all(MYSQLI_ASSOC);
				$sentencia->close();

			}else{
				$error = "E - Problemas al obtener los items del pedido. ".$sentencia->error;
			}

		}else{
			$error = "B - Problemas al obtener los items del pedido. ".$sentencia->error;
		}

	}else{
		$error = "P - Problemas al obtener los items del pedido. ".$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);
}

function obtenerEstadoPedido($conexion,$idestado){

	$sentencia = $conexion->prepare('SELECT * FROM estado_pedido WHERE id_estado = ?');

	$error = null;
	$resultado = null;

	if( $sentencia ){

		if ( $sentencia->bind_param('i',$idestado)){

			if( $sentencia->execute()){
				$items = $sentencia->get_result();
				$resultado = $items->fetch_assoc();
				$sentencia->close();

			}else{
				$error = "P - Problemas al obtener el estado del pedido. ".$sentencia->error;
			}

		}else{
			$error = "P - Problemas al obtener el estado del pedido. ".$sentencia->error;
		}

	}else{
		$error = "P - Problemas al obtener el estado del pedido. ".$conexion->error;
	}

	return array('resultado' => $resultado, 'error' => $error);
}

?>