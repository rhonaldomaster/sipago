<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
	include_once("../modelos/clienteModelo.php");
	$id = $_REQUEST['id'];
	$objmodelo = new ClienteModelo();
	$arr = $objmodelo->buscarClientePorId($id);
	$arr2 = explode("|",$arr);
	$ap = $arr2[0];
	$nm = $arr2[1];
	$idn = $arr2[2];
	$idtipo = $arr2[3];
	$dir = $arr2[4];
	$idmun = $arr2[5];
	$coddep = $arr2[6];
	$tel = $arr2[7];
?>
<script>
	function cargarDeps(idsel,idselp){
		$("#"+idsel).html("");
		$.post("./scripts/clienteControl.php",{opcion:9},function(resp){
			$("#"+idsel).html(resp);
			cargarPobs(idsel,idselp);
		});
	}
	function cargarPobs(idseld,idsel){
		$("#"+idsel).html("");
		var iddep = $("#"+idseld+" option:selected").val();
		$.post("./scripts/clienteControl.php",{opcion:10,iddep:iddep},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	function cargarDepSel(idsel,idsel2,iddep,idmun){
		$("#"+idsel).html("");
		$.post("./scripts/clienteControl.php",{opcion:11,iddep:iddep},function(resp){
			$("#"+idsel).html(resp);
			cargarMunicipioSel(idsel2,iddep,idmun);
		});
	}
	function cargarMunicipioSel(idsel,iddep,idmun){
		$("#"+idsel).html("");
		if(iddep=='' || iddep=='0') iddep = $("#dep option:selected").val();
		$.post("./scripts/clienteControl.php",{opcion:12,iddep:iddep,idmun:idmun},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	$(document).ready(function(){
		cargarTipoId('tipoid');
		cargarDepSel('dep','pob','<?php echo $coddep; ?>',<?php echo $idmun; ?>);
	});
</script>
<form id="frmmodcli">
	<input id="idcli" name="idcli" type="hidden" value="<?php echo $id; ?>">
	<table>
		<tr>
			<td>Tipo identificacion</td>
			<td><select id="tipoid" name="tipoid" style="width:10rem;"></select></td>
			<td>Identificacion</td>
			<td><input type="text" id="identificacion" name="identificacion" value="<?php echo $idn; ?>"></td>
		</tr>
		<tr>
			<td>Nombre(s)</td>
			<td><input type="text" id="nombrecli" name="nombrecli" required value="<?php echo $nm; ?>"></td>
			<td>Apellido(s)</td>
			<td><input type="text" id="apellidocli" name="apellidocli" required value="<?php echo $ap; ?>"></td>
		</tr>
		<tr>
			<td>Direcci&oacute;n</td>
			<td><input type="text" id="dircli" name="dircli" required value="<?php echo $dir; ?>"></td>
			<td>Tel&eacute;fono</td>
			<td><input type="text" id="telcli" name="telcli" required value="<?php echo $tel; ?>"></td>
		</tr>
		<tr>
			<td>Departamento</td>
			<td><select id="dep" name="dep" onchange="cargarPobs(this.id,'pob');" style="width:10rem;"></select></td>
			<td>Municipio/Poblaci&oacute;n</td>
			<td><select id="pob" name="pob" style="width:10rem;"></select></td>
		</tr>
		<tr>
			<td colspan="4" style="text-align: center;">
				<input type="button" value="Enviar" onclick="modificarCliente('frmmodcli');">
			</td>
		</tr>
	</table>
</form>
