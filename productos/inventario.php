<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
	include_once("../scripts/funciones.php");
?>
<script>
	function buscarProductos(){
		$("#datos").html("Consultando, por favor espere");
		$.getJSON("./scripts/productoControl.php",{opcion:2},function(data){
			if(data.productos[0]!=null){
				var html1 = "<table id='tblcuentas' class='tablesorter' cellspacing='0'>";
				html1 += "<thead><tr><th class='header'>Nombre</th><th class='header'>Cantidad</th>";
				html1 += "</tr><thead><tbody></tbody><tfoot></tfoot></table>";
				$("#datos").html(html1);
				$.each(data.productos, function(i,producto){
					var html2 = "";
					html2 = "<tr>";
					if(producto.id==""){
						var cspan = 2;
						html2 += "<td colspan='"+cspan+"' style='text-align: center;'>No se encontraron resultados</td>";
					}
					else{
						html2 += "<td>"+producto.nombre+"</td>";
						html2 += "<td>"+producto.cantidad+"</td>";
					}
					html2 += "</tr>";
					$("#tblcuentas tbody").append(html2);
					$(".tablesorter").tablesorter();
				});
			}
			else{
				jAlert("Ocurri\u00F3 un problema al obtener los datos","Error");
			}
		});
	}
	function salidasMes(iddiv,idanio,idmes){
		$("#"+iddiv).html("Consultando, por favor espere");
		var anio = $("#"+idanio+" option:selected").val();
		var mes = $("#"+idmes+" option:selected").val();
		$.getJSON("./scripts/productoControl.php",{opcion:8,anio:anio,mes:mes},function(data){
			if(data.productos[0]!=null){
				var html1 = "<table id='tblsalidas' class='tablesorter' cellspacing='0'>";
				html1 += "<thead><tr><th class='header'>Nombre</th><th class='header'>Cantidad</th>";
				html1 += "</tr><thead><tbody></tbody><tfoot></tfoot></table>";
				$("#"+iddiv).html(html1);
				$.each(data.productos, function(i,producto){
					var html2 = "";
					html2 = "<tr>";
					if(producto.id==""){
						var cspan = 2;
						html2 += "<td colspan='"+cspan+"' style='text-align: center;'>No se encontraron resultados</td>";
					}
					else{
						html2 += "<td>"+producto.nombre+"</td>";
						html2 += "<td>"+producto.cantidad+"</td>";
					}
					html2 += "</tr>";
					$("#tblsalidas tbody").append(html2);
					$(".tablesorter").tablesorter();
				});
			}
			else{
				jAlert("Ocurri\u00F3 un problema al obtener los datos","Error");
			}
		});
	}
	function entradasMes(iddiv,idanio,idmes){
		$("#"+iddiv).html("Consultando, por favor espere");
		var anio = $("#"+idanio+" option:selected").val();
		var mes = $("#"+idmes+" option:selected").val();
		$.getJSON("./scripts/productoControl.php",{opcion:9,anio:anio,mes:mes},function(data){
			if(data.productos[0]!=null){
				var html1 = "<table id='tblentradas' class='tablesorter' cellspacing='0'>";
				html1 += "<thead><tr><th class='header'>Nombre</th><th class='header'>Cantidad</th>";
				html1 += "</tr><thead><tbody></tbody><tfoot></tfoot></table>";
				$("#"+iddiv).html(html1);
				$.each(data.productos, function(i,producto){
					var html2 = "";
					html2 = "<tr>";
					if(producto.id==""){
						var cspan = 2;
						html2 += "<td colspan='"+cspan+"' style='text-align: center;'>No se encontraron resultados</td>";
					}
					else{
						html2 += "<td>"+producto.nombre+"</td>";
						html2 += "<td>"+producto.cantidad+"</td>";
					}
					html2 += "</tr>";
					$("#tblentradas tbody").append(html2);
					$(".tablesorter").tablesorter();
				});
			}
			else{
				jAlert("Ocurri\u00F3 un problema al obtener los datos","Error");
			}
		});
	}
	function productosSelect(idsel){
		$("#"+idsel).html("<option value='-1'>Buscando...</option>");
		$.post("./scripts/productoControl.php",{opcion:10},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	$(document).ready(function(){
		activar_tabs();
		buscarProductos();
		productosSelect("selproding");
		productosSelect("selprodsal");
	});
</script>
<div style="width: 96%">
	<ul class='tabs'>
		<li><a href='#tab1'>General</a></li>
		<li><a href='#tab2'>Salidas por mes</a></li>
		<li><a href='#tab3'>Entradas por mes</a></li>
	</ul>
	<div class='tab_container'>
		<div id="tab1" class='tab_content'>
			<table>
				<tr>
					<td>
						<input type="button" value="Actualizar" onclick="buscarProductos();">
					</td>
				</tr>
			</table>
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
			<input type="button" value="Actualizar" onclick="salidasMes('datos2','aniotrans','mestrans');">
			<br><br>
			<div id="datos2"></div>
		</div><!--tab2-->
		<div id="tab3" class='tab_content'>
			Seleccione a&ntilde;o y mes:
			<select id="aniotranse">
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
			<select id="mestranse">
				<?php
					for($i=1;$i<13;$i++){
						$sel = "";
						if($i==date("n")) $sel = " selected";
						echo "<option value='$i'$sel>".nombreMes($i)."</option>";
					}
				?>
			</select>
			<input type="button" value="Actualizar" onclick="entradasMes('datos3','aniotranse','mestranse');">
			<br><br>
			<div id="datos3"></div>
		</div><!--tab3-->
	</div><!--tabcontainer-->
	<div style="clear:both;"></div>
</div>
