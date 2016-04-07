<?php
	include_once("../modelos/facturaModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new FacturaModelo();
	$tipofact = $_REQUEST['tipofact'];
	$rstext = $objmodelo->ingresarFactura($_REQUEST['idcliente'],$_REQUEST['valorf'],$_REQUEST['fechaf'],$_REQUEST['fechalim'],utf8_encode($_REQUEST['descf']));
	$atr = explode("|",$rstext);
	$mtext = $atr[0];
	if($atr[1]!=null && strcasecmp("",$atr[1])!=0){
		if($tipofact==1){
			$kt = $objmodelo->ingresarCuentaxCobrar($atr[1]);
		}
		if($tipofact==2){
			$kt = $objmodelo->ingresarCuentaxPagar($atr[1]);
		}
	}
	echo $mtext."\n".$kt;
?>
