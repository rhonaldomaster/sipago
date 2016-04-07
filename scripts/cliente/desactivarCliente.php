<?php
	include_once("../modelos/clienteModelo.php");
	$objmodelo = new ClienteModelo();
	$txt = $objmodelo->desactivarCliente($_REQUEST['id']);
	echo utf8_encode($txt);
?>
