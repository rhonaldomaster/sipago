<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
	include_once("../scripts/funciones.php");
?>
<script>
	function transaccionesDia(iddiv){
		$("#"+iddiv).html("Consultando, por favor espere");
		var fecha = $("#fechaldiario").val();
		if($.trim(fecha)!=""){
			$.post("./scripts/contabilidadControl.php",{opcion:1,fecha:fecha},function(resp){
				$("#"+iddiv).html(resp);
			});
		}
		else{
			jAlert("Debe seleccionar una fecha","Error");
		}
	}
	function transaccionesMes(iddiv,idanio,idmes){
		$("#"+iddiv).html("Consultando, por favor espere");
		var anio = $("#"+idanio+" option:selected").val();
		var mes = $("#"+idmes+" option:selected").val();
		$.post("./scripts/contabilidadControl.php",{opcion:2,anio:anio,mes:mes},function(resp){
			$("#"+iddiv).html(resp);
		});
	}
	$(document).ready(function(){
		activar_tabs();
		transaccionesDia("datos");
		transaccionesMes('datos2','aniotrans','mestrans');
	});
</script>
<div style="width: 99%">
	<ul class='tabs'>
		<li><a href='#tab1'>Transacciones d&iacute;a</a></li>
		<li><a href='#tab2'>Transacciones mes</a></li>
	</ul>
	<div class='tab_container'>
		<div id="tab1" class='tab_content'>
			Fecha: 
			<input type="text" id="fechaldiario" name="fechaldiario" value="<?php echo date("Y-m-d"); ?>" required readonly onchange="libroDiario('datos');">
			<img src="./img/cal.gif" title="Abrir Calendario" style="cursor:pointer;" onclick="displayCalendar(document.getElementById('fechaldiario'),'yyyy-mm-dd',this)">
			<input type="button" value="Actualizar" onclick="transaccionesDia('datos');">
			<br><br>
			<div id="datos"></div>
		</div><!--tab1-->
		<div id="tab2" class='tab_content'>
			Seleccione a&ntilde;o y mes:
			<select id="aniotrans">
				<?php
					$aini = 2001;
					$afin = date("Y");
					for($i=$aini;$i<=$afin;$i++){
						$sel = "";
						if($i==$afin) $sel = " selected";
						echo "<option value='$i'$sel>$i</option>";
					}
				?>
			</select>
			<select id="mestrans">
				<?php
					for($i=1;$i<13;$i++){
						$sel = "";
						if($i==date("n")) $sel = " selected";
						echo "<option value='$i'$sel>".nombreMes($i)."</option>";
					}
				?>
			</select>
			<input type="button" value="Actualizar" onclick="transaccionesMes('datos2','aniotrans','mestrans');">
			<br><br>
			<div id="datos2"></div>
		</div><!--tab2-->
	</div><!--tabcontainer-->
	<div style="clear:both;"></div>
</div>
