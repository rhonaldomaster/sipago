<?php
	include_once("../modelos/areaModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new AreaModelo();
	$menutext = $objmodelo->asignarAreaPerfil($_REQUEST['idarea'],$_REQUEST['idperf']);
	echo $menutext;
?>
