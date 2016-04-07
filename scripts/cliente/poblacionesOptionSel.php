<?php
	include_once("../modelos/clienteModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new ClienteModelo();
	$menutext = $objmodelo->listaPoblaciones_OptionSel($_REQUEST['iddep'],$_REQUEST['idmun']);
	echo $menutext;
?>
