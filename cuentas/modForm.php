<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
	if(!isset($_REQUEST['id'])){
		die("Proporcione la informacion necesaria para continuar");
	}
	$id = $_REQUEST['id'];
	include_once("../modelos/cuentasModelo.php");
	$objmodelo = new CuentasModelo();
	$texto = utf8_encode($objmodelo->buscarCuentaPorId($id));
	$aspl = explode("|",$texto);
	$codigo = $aspl[0];
	$nombre = $aspl[1];
?>
<div>
	<form id="fmodcuenta" method="POST" action="">
		<input type="hidden" id="idcuentamod" name="idcuentamod" value="<?php echo $id; ?>">
		<table>
			<tr>
				<th colspan="2" style="text-align: center;">
					Modificar cuenta
				</th>
			</tr>
			<tr>
				<td>Codigo/Numero</td>
				<td><input type="text" id="codcuentamod" name="codcuentamod" value="<?php echo $codigo; ?>"></td>
			</tr>
			<tr>
				<td>Nombre/Descripcion</td>
				<td><input type="text" id="nomcuentamod" name="nomcuentamod" value="<?php echo $nombre; ?>"></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;">
					<input type="button" value="Enviar" onclick="modificarCuenta('fmodcuenta');">
				</td>
			</tr>
		</table>
	</form>
</div>
