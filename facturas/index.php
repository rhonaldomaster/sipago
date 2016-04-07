<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
?>
<script>
	function listaClientes(idsel){
		$.post("./scripts/clienteControl.php",{opcion:1},function(resp){
			$("#"+idsel).html("<option value='0'>...</option>"+resp);
		});
	}
	function crearFactura(idform){
		var data = $("#"+idform).serialize()+"&opcion=1";
		$.post("./scripts/facturaControl.php",data,function(resp){
			jAlert(resp,"Informacion");
			document.getElementById(idform).reset();
		});
	}
	$(document).ready(function(){
		listaClientes("idcliente");
		$("select,input[type=text]").css({'width':'80%'});
	});
</script>
<div style="margin: 0 auto; width:70%;">
	<form id="factform">
		<table class="tablesorter">
			<thead>
				<tr>
					<th colspan="2">Creaci&oacute;n de factura</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>Tipo de factura</th>
					<td style="text-align:right;">
						<select id="tipofact" name="tipofact">
							<option value="1">Cuenta por cobrar</option>
							<option value="2">Cuenta por pagar</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Cliente</th>
					<td style="text-align:right;"><select id="idcliente" name="idcliente"></select></td>
				</tr>
				<tr>
					<th>Valor</th>
					<td style="text-align:right;"><input type="text" id="valorf" name="valorf" style="text-align:right;" required></td>
				</tr>
				<tr>
					<th>Fecha</th>
					<td style="text-align:right;">
						<input type="text" id="fechaf" name="fechaf" required readonly>
						<img src="./img/cal.gif" title="Abrir Calendario" style="cursor:pointer;" onclick="displayCalendar(document.getElementById('fechaf'),'yyyy-mm-dd',this)">
					</td>
				</tr>
				<tr>
					<th>Fecha limite</th>
					<td style="text-align:right;">
						<input type="text" id="fechalim" name="fechalim" readonly>
						<img src="./img/cal.gif" title="Abrir Calendario" style="cursor:pointer;" onclick="displayCalendar(document.getElementById('fechalim'),'yyyy-mm-dd',this)">
					</td>
				</tr>
				<tr>
					<th style="vertical-align:top;">Descripcion</th>
					<td style="text-align:right;"><textarea id="descf" name="descf" cols="50" rows="5"></textarea></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center;">
						<input type="button" value="Enviar" onclick="crearFactura('factform');">
						<input type="reset" value="Borrar">
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
