<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	if(!isset($_REQUEST['id'])){
		die("Proporcione la informacion necesaria para continuar");
	}
	$id = $_REQUEST['id'];
	include_once("../modelos/productoModelo.php");
	$objmodelo = new ProductoModelo();
	$texto = utf8_encode($objmodelo->buscarProductoPorId($id));
	$aspl = explode("|",$texto);
	$nombre = $aspl[0];
	$activo = $aspl[1];
?>
<div>
	<form id="fmodprod" method="POST" action="">
		<input type="hidden" id="idamod" name="idamod" value="<?php echo $id; ?>">
		<table>
			<tr>
				<th colspan="2" style="text-align: center;">
					Modificar producto
				</th>
			</tr>
			<tr>
				<td>Nombre/Descripcion</td>
				<td><input type="text" id="nomamod" name="nomamod" value="<?php echo $nombre; ?>"></td>
			</tr>
			<tr>
				<td>Activo</td>
				<td>
					<select id="actmod" name="actmod">
						<option value="0"<?php if($activo==0) echo " selected"; ?>>Inactivo</option>
						<option value="1"<?php if($activo==1) echo " selected"; ?>>Activo</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;">
					<input type="button" value="Enviar" onclick="modificarProducto('fmodprod');">
				</td>
			</tr>
		</table>
	</form>
</div>
