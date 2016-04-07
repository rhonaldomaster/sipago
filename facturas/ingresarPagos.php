<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
?>
<script>
	function listarClienteTipo(idtp,idscli){
		$("#"+idscli).html("<option>Buscando</option>");
		var tipocl = $("#"+idtp+" option:selected").val();
		$.post("./scripts/clienteControl.php",{opcion:3,tipo:tipocl},function(resp){
			$("#"+idscli).html(resp);
			facturasClienteAcreedor(idscli,idtp,'idfact');
		});
	}
	function facturasClienteAcreedor(idscli,idtp,idsf){
		$("#"+idsf).html("<option>Buscando</option>");
		var idcl = $("#"+idscli+" option:selected").val();
		var tipocl = $("#"+idtp+" option:selected").val();
		$.post("./scripts/facturaControl.php",{opcion:5,tipo:tipocl,idcl:idcl},function(resp){
			$("#"+idsf).html(resp);
		});
	}
	function ingresarPago(){
		var clasep = $("#clpago option:selected").val();
		var idfact = $("#idfact option:selected").val();
		var tipo = $("#tipoingreso option:selected").val();
		var idcuenta = $("#idcuenta option:selected").val();
		var tiposoporte = $("#tiposoporte option:selected").val();
		var val = $("#valorp").val();
		var numsoporte = $("#numsoporte").val();
		var fechapago = $("#fechapago").val();
		var data = {
			clase:clasep,idfact:idfact,
			tipo:tipo, valor:val,
			idcuenta:idcuenta,numsoporte:numsoporte,
			tiposoporte:tiposoporte,fechapago:fechapago,
			opcion:6
		}
		$.post("./scripts/facturaControl.php",data,function(resp){
			jAlert(resp,"Informacion");
		});
	}
	function listaCuentas(idsel){
		$.post("./scripts/cuentasControl.php",{opcion:7,idarea:1,idsub:1},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	function listaComprobantes(idsel){
		$.post("./scripts/facturaControl.php",{opcion:7},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	function listaSoportes(idsel){
		$.post("./scripts/facturaControl.php",{opcion:8},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	$(document).ready(function(){
		listarClienteTipo("clpago","idcli");
		listaCuentas("idcuenta");
		listaComprobantes("tipoingreso");
		listaSoportes("tiposoporte");
		$("select").css({"width":"15rem"});
	});
</script>
<table>
	<tr>
		<td>Clase</td>
		<td>
			<select id="clpago" onchange="listarClienteTipo(this.id,'idcli');">
				<option value="1">Pago de cliente</option>
				<option value="2">Pago a acreedor</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Cliente/Acreedor</td>
		<td>
			<select id="idcli" onchange="facturasClienteAcreedor(this.id,'clpago','idfact');"></select>
		</td>
	</tr>
	<tr>
		<td>Factura</td>
		<td>
			<select id="idfact"></select>
		</td>
	</tr>
	<tr>
		<td>Tipo</td>
		<td>
			<select id="tipoingreso"></select>
		</td>
	</tr>
	<tr>
		<td>Cuenta</td>
		<td>
			<select id="idcuenta"></select>
		</td>
	</tr>
	<tr>
		<td>Soporte</td>
		<td>
			<select id="tiposoporte"></select>
		</td>
	</tr>
	<tr>
		<td>No. soporte</td>
		<td>
			<input type="text" id="numsoporte" value="">
		</td>
	</tr>
	<tr>
		<td>Fecha</td>
		<td>
			<input type="text" id="fechapago" value="<?php echo date("Y-m-d"); ?>" required readonly>
			<img src="./img/cal.gif" title="Abrir Calendario" style="cursor:pointer;" onclick="displayCalendar(document.getElementById('fechapago'),'yyyy-mm-dd',this)">
		</td>
	</tr>
	<tr>
		<td>Valor</td>
		<td>
			<input type="text" id="valorp" value="0">
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<input type="button" value="Enviar" onclick="ingresarPago();">
		</td>
	</tr>
</table>
