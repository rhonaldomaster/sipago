<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
?>
<script>
	function cargarAreas(idsel,idselgrupo){
		$.post("./scripts/cuentasControl.php",{opcion:1},function(resp){
			$("#"+idsel).html(resp);
			cargarSubgrupos(idsel,idselgrupo);
		});
	}
	function cargarSubgrupos(idselarea,idsel){
		var idarea = $("#"+idselarea+" option:selected").val();
		$.post("./scripts/cuentasControl.php",{idarea:idarea,opcion:2},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	function registrarCuenta(ida,idsg,idcd,idnm){
		var idarea = $("#"+ida+" option:selected").val();
		var idsub = $("#"+idsg+" option:selected").val();
		var codigo = $("#"+idcd).val();
		var nombre = $("#"+idnm).val();
		codigo = $.trim(codigo);
		nombre = $.trim(nombre);
		if(codigo=="" || nombre==""){
			jAlert("Debe escribir texto para codigo/numero y nombre/descripcion","Aviso");
		}
		else{
			$.post("./scripts/cuentasControl.php",{opcion:3,idarea:idarea,idsub:idsub,codigo:codigo,nombre:nombre},function(resp){
				jAlert(resp,"Actualizacion");
			});
		}
	}
	function buscarCuentasPorAreaYGrupo(ida,idsg,accion){
		var idarea = $("#"+ida+" option:selected").val();
		var idsub = $("#"+idsg+" option:selected").val();
		$.getJSON("./scripts/cuentasControl.php",{idarea:idarea,idsub:idsub,opcion:4},function(data){
			if(data.cuentas[0]!=null){
				var html1 = "<table id='tblcuentas' class='tablesorter' cellspacing='0'>";
				html1 += "<thead><tr><th class='header'>Codigo</th><th class='header'>Nombre</th><th class='header'>Activo</th>";
				if(accion==2){
					html1 += "<th class='header'>Acci&oacute;n</th>";
				}
				html1 += "</tr><thead><tbody></tbody><tfoot></tfoot></table>";
				$("#datos").html(html1);
				$.each(data.cuentas, function(i,cuenta){
					var html2 = "";
					html2 = "<tr>";
					if(cuenta.id==""){
						var cspan = 3;
						if(accion==2){
							cspan=4;
						}
						html2 += "<td colspan='"+cspan+"' style='text-align: center;'>No se encontraron resultados</td>";
					}
					else{
						html2 += "<td>"+cuenta.codigo+"</td>";
						html2 += "<td>"+cuenta.nombre+"</td>";
						html2 += "<td>"+( (cuenta.activo==1) ? "S&iacute;":"No")+"</td>";
						if(accion==2){
							html2 += "<td><input type='image' title='Editar' src='./img/icn_edit.png' onclick='editarCuenta("+cuenta.id+");' alt='Editar'>";
							html2 += " <input type='image' title='Desactivar' src='./img/icn_trash.png' onclick='desactivarCuenta("+cuenta.id+");' alt='Borrar'></td>";
						}
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
	function desactivarCuenta(id){
		var ir = jConfirm("Seguro que desea desactivar esta cuenta?","Advertencia");
		if(ir==true){
			$.post("./scripts/cuentasControl.php",{id:id,opcion:5},function(resp){
				jAlert(resp,"Informacion");
				buscarCuentasPorAreaYGrupo('areacuentamod','subgrupocuentamod',2);
			});
		}
	}
	function editarCuenta(id){
		$("#datos").load("./cuentas/modForm.php?id="+id);
	}
	function modificarCuenta(idform){
		var data = $("#"+idform).serialize()+"&opcion=6";
		$.post("./scripts/cuentasControl.php",data,function(resp){
			jAlert(resp,"Informacion");
			buscarCuentasPorAreaYGrupo('areacuentamod','subgrupocuentamod',2);
		});
	}
	$(document).ready(function(){
		activar_tabs();
		cargarAreas("areacuentamod","subgrupocuentamod");
		cargarAreas("areacuenta","subgrupocuenta");
		//buscarCuentasPorAreaYGrupo('areacuentamod','subgrupocuentamod',2);
	});
</script>
<div style="width: 96%">
	<ul class='tabs'>
		<li><a href='#tab1'>Modificar cuenta</a></li>
		<li><a href='#tab2'>Crear cuenta</a></li>
	</ul>
	<div class='tab_container'>
		<div id="tab1" class='tab_content'>
			<table>
				<tr>
					<td>Area</td>
					<td><select id="areacuentamod" onchange="cargarSubgrupos('areacuentamod','subgrupocuentamod');"></select></td>
				</tr>
				<tr>
					<td>Subgrupo</td>
					<td><select id="subgrupocuentamod"></select></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center;">
						<input type="button" value="Buscar" onclick="buscarCuentasPorAreaYGrupo('areacuentamod','subgrupocuentamod',2);">
					</td>
				</tr>
			</table>
			<br><br>
			<div id="datos"></div>
		</div><!--tab1-->
		<div id="tab2" class='tab_content'>
			<table>
				<tr>
					<td>Area</td>
					<td><select id="areacuenta" onchange="cargarSubgrupos('areacuenta','subgrupocuenta');"></select></td>
				</tr>
				<tr>
					<td>Subgrupo</td>
					<td><select id="subgrupocuenta"></select></td>
				</tr>
				<tr>
					<td>Codigo/Numero</td>
					<td><input type="text" id="codigocuenta" required></td>
				</tr>
				<tr>
					<td>Nombre/Descripcion</td>
					<td><input type="text" id="nombrecuenta" required></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center;">
						<input type="button" value="Enviar" onclick="registrarCuenta('areacuenta','subgrupocuenta','codigocuenta','nombrecuenta');">
					</td>
				</tr>
			</table>
		</div><!--tab2-->
	</div><!--tabcontainer-->
	<div style="clear:both;"></div>
</div>
