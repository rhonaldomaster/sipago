<?php
	include_once("../modelos/clienteModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new ClienteModelo();
	$menutext = $objmodelo->listadoClientesTipo_Option($_REQUEST['tipo']);
	echo $menutext;
?>
