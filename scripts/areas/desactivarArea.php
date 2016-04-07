<?php
	include_once("../modelos/areaModelo.php");
	$objmodelo = new AreaModelo();
	$menutext = $objmodelo->desactivarArea($_REQUEST['id']);
	echo $menutext;
?>
