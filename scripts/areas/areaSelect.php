<?php
	include_once("../modelos/areaModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new AreaModelo();
	$menutext = $objmodelo->listadoArea_Option();
	echo $menutext;
?>
