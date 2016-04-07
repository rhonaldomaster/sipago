<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
	include_once("../modelos/menuModelo.php");
	$id = $_REQUEST['id'];
	$objmodelo = new MenuModelo();
	$arr = $objmodelo->datosMenu($id);
	$arr2 = explode("|",$arr);
	$idarea=$arr2[0];
	$texto=$arr2[1];
	$link = $arr2[2];
?>
<script>
	$(document).ready(function(){
		activar_tabs();
		listaAreasSel("idaream",<?php echo $idarea; ?>);
	});
</script>
<form id="frmenum" method="POST" action="">
	<input id="idmenumod" name="idmenumod" type="hidden" value="<?php echo $id ?>">
	<table>
		<tr>
			<td colspan="2">Modificaci&oacute;n de menu</td>
		</tr>
		<tr>
			<td>Area</td>
			<td><select id="idaream" name="idaream"></select></td>
		</tr>
		<tr>
			<td>Nombre</td>
			<td><input type="text" id="nomenum" name="nomenum" value="<?php echo $texto; ?>" required></td>
		</tr>
		<tr>
			<td>Link</td>
			<td><input type="text" id="linkmenum" name="linkmenum" value="<?php echo $link; ?>" required></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: center;">
				<input type="button" value="Enviar" onclick="modificarMenu('frmenum');">
				<input type="reset" value="Borrar">
			</td>
		</tr>
	</table>
</form>
