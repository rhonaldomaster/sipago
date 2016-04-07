<?php
	include_once("../modelos/clienteModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new ClienteModelo();
	$menutext = $objmodelo->listaDepartamentos_OptionSel($_REQUEST['iddep']);
	echo $menutext;
?>
