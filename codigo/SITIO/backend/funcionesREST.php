<?php
/*=============================================
ARCHIVO : funcionesREST.php
CONTENIDO: funciones para consulta al servicio
		   REST (GET)
===============================================*/
define('URL_REST', 'http://localhost/INTERFACES_PROGRAMACION_VISUAL/TP_FINAL/TIENDA_DE_OFERTAS/REST/rest.php');


function obtenerOfertas(){
	return json_decode(file_get_contents(URL_REST),true);
}

function obtenerOferta($idoferta){
	return json_decode(file_get_contents(URL_REST."?id_oferta=$idoferta"),true);
}

function obtenerProducto($idproducto){
	return json_decode(file_get_contents(URL_REST."?id_producto=$idproducto"),true);
}
?>