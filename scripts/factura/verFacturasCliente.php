<?php
	include_once("../modelos/facturaModelo.php");
	$objmodelo = new FacturaModelo();
	$rstext = $objmodelo->verFacturasCliente($_REQUEST['idcliente']);
	echo utf8_decode($rstext);
?>
