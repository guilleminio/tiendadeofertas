<?php
$conexion = new mysqli('localhost','root','','ofertas');

if ( $conexion->connect_error)
	die('PROBLEMAS');



if ($_SERVER['REQUEST_METHOD'] == 'GET')
{

	if ( isset($_GET['id_oferta'])){

		$sentencia = $conexion->prepare('SELECT * FROM oferta WHERE id_oferta = ?');

		if ($sentencia){
       		if ( $sentencia->bind_param('i',$_GET['id_oferta'])){
       			if ( $sentencia->execute()){

       				if ( $detalle = $sentencia->get_result()){
	       				header("HTTP/1.1 200 OK");
	       				echo json_encode($detalle->fetch_assoc());
	       				exit();
       				}
       			}
       		}
       }

	}else if(!isset($_GET['id_producto'])){

		$sentencia = $conexion->prepare('SELECT * FROM oferta');

		$sentencia->execute();

		$ofertas = $sentencia->get_result();
		header("HTTP/1.1 200 OK");
		echo json_encode($ofertas->fetch_All(MYSQLI_ASSOC));
		exit();
	}


	if ( isset($_GET['id_producto'])){
		
		$sentencia = $conexion->prepare('SELECT * FROM producto WHERE id_producto = ?');

		if ($sentencia){
       		if ( $sentencia->bind_param('i',$_GET['id_producto'])){
       			if ( $sentencia->execute()){

       				if ( $detalle = $sentencia->get_result()){
	       				header("HTTP/1.1 200 OK");
	       				echo json_encode($detalle->fetch_assoc());
	       				exit();
       				}
       			}
       		}
       }
   }

}


header("HTTP/1.1 404 SOLICITUD NO ENCONTRADA");

?>