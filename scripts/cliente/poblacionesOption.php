<?php
	include_once("../modelos/clienteModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new ClienteModelo();
	$menutext = $objmodelo->listaPoblaciones_Option($_REQUEST['iddep']);
	echo $menutext;
?>
