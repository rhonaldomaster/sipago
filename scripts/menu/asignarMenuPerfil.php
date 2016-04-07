<?php
	include_once("../modelos/menuModelo.php");
	$objmodelo = new MenuModelo();
	$text = utf8_decode($objmodelo->asignarMenuPerfil($_REQUEST['menuasig'],$_REQUEST['perfasig']));
	echo $text;
?>
