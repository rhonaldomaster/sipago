<?php
	include_once("../modelos/clienteModelo.php");
	$objmodelo = new ClienteModelo();
	$txt = $objmodelo->buscarClientes();
	echo utf8_encode($txt);
?>
