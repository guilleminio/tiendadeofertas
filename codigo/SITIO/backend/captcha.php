<?php
session_start();
define('LONGITUD_CAPTCHA',5);
define('FUENTE_CAPTCHA','../fuentes/arial.ttf');
define('IMAGEN_CAPTCHA','../imagenes/captchabg.jpg');


function generarCaptcha(){
	$patron = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	$captcha = "";
	$longitudPatron = strlen($patron);
	for ( $i = 0; $i < LONGITUD_CAPTCHA; $i++){
		$captcha.=$patron[rand(0,$longitudPatron)];
	}
	return $captcha;
}

$_SESSION['captchaactual'] = generarCaptcha();

$imagenFondo = imagecreatefromjpeg(IMAGEN_CAPTCHA);
$colorTexto = imagecolorallocate($imagenFondo, 0, 0, 0);

imagettftext($imagenFondo, 32, 0, 50, 50, $colorTexto, FUENTE_CAPTCHA, $_SESSION['captchaactual']);



header('Content-type: image/jpg');
imagejpeg($imagenFondo);

?>