<?php
	include_once("../modelos/clienteModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new ClienteModelo();
	$menutext = $objmodelo->ingresarCliente();
	echo $menutext;
?>
