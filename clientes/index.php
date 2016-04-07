<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
?>
<script>
	function buscarClientes(accion){
		$.getJSON("./scripts/clienteControl.php",{opcion:4},function(data){
			if(data.clientes[0]!=null){
				var html1 = "<table id='tblclientes' class='tablesorter' cellspacing='0'>";
				html1 += "<thead><tr><th class='header'>Nombre(s)</th><th class='header'>Apellido(s)</th><th class='header'>Identificacion</th><th class='header'>Activo</th>";
				if(accion==2){
					html1 += "<th class='header'>Acci&oacute;n</th>";
				}
				html1 += "</tr><thead><tbody></tbody><tfoot></tfoot></table>";
				$("#datos").html(html1);
				$.each(data.clientes, function(i,cliente){
					var html2 = "";
					html2 = "<tr>";
					if(cliente.id==""){
						var cspan = 4
						if(accion==2){
							cspan=5;
						}
						html2 += "<td colspan='"+cspan+"' style='text-align: center;'>No se encontraron resultados</td>";
					}
					else{
						html2 += "<td>"+cliente.nombres+"</td>";
						html2 += "<td>"+cliente.apellidos+"</td>";
						html2 += "<td>"+cliente.identificacion+"</td>";
						html2 += "<td>"+( (cliente.activo==1) ? "S&iacute;":"No")+"</td>";
						if(accion==2){
							html2 += "<td><input type='image' title='Editar' src='./img/icn_edit.png' onclick='editarCliente("+cliente.id+");' alt='Editar'>";
							html2 += " <input type='image' title='Desactivar' src='./img/icn_trash.png' onclick='desactivarCliente("+cliente.id+");' alt='Borrar'></td>";
						}
					}
					html2 += "</tr>";
					$("#tblclientes tbody").append(html2);
					$(".tablesorter").tablesorter();
				});
			}
			else{
				jAlert("Ocurri\u00F3 un problema al obtener los datos","Error");
			}
		});
	}
	function editarCliente(id){
		$("#datos").load("./clientes/modForm.php?id="+id);
	}
	function modificarCliente(idform){
		var data = $("#"+idform).serialize()+"&opcion=5";
		$.post("./scripts/clienteControl.php",data,function(resp){
			jAlert(resp,"Informacion");
			buscarClientes(2);
		});
	}
	function desactivarCliente(id){
		var ir = jConfirm("Seguro que desea desactivar este cliente?","Advertencia");
		if(ir==true){
			$.post("./scripts/clienteControl.php",{id:id,opcion:6},function(resp){
				jAlert(resp,"Informacion");
				buscarClientes(2);
			});
		}
	}
	function registrarCliente(idform,ididen,idnm){
		var ididen = $("#"+ididen).val();
		var nombre = $("#"+idnm).val();
		ididen = $.trim(ididen);
		nombre = $.trim(nombre);
		if(ididen=="" || nombre==""){
			jAlert("Debe escribir texto para identificacion y nombre","Aviso");
		}
		else{
			var data = $("#"+idform).serialize()+"&opcion=7";
			$.post("./scripts/clienteControl.php",data,function(resp){
				jAlert(resp,"Actualizacion");
			});
		}
	}
	function cargarTipoId(idsel){
		$("#"+idsel).html("");
		$.post("./scripts/clienteControl.php",{opcion:8},function(resp){
			$("#"+idsel).html(resp);
		});
	}
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
	$(document).ready(function(){
		activar_tabs();
		buscarClientes(2);
		cargarTipoId('tipoid');
		cargarDeps('dep','pob');
	});
</script>
<div style="width: 96%">
	<ul class='tabs'>
		<li><a href='#tab1'>Modificar cliente</a></li>
		<li><a href='#tab2'>Crear cliente</a></li>
	</ul>
	<div class='tab_container'>
		<div id="tab1" class='tab_content'>
			<input type="button" value="Actualizar" onclick="buscarClientes(2);">
			<br><br>
			<div id="datos"></div>
		</div><!--tab1-->
		<div id="tab2" class='tab_content'>
			<form id="frmregcli">
				<table>
					<tr>
						<td>Tipo identificacion</td>
						<td><select id="tipoid" name="tipoid" style="width:10rem;"></select></td>
						<td>Identificacion</td>
						<td><input type="text" id="identificacion" name="identificacion"></td>
					</tr>
					<tr>
						<td>Nombre(s)</td>
						<td><input type="text" id="nombrecli" name="nombrecli" required></td>
						<td>Apellido(s)</td>
						<td><input type="text" id="apellidocli" name="apellidocli" required></td>
					</tr>
					<tr>
						<td>Direcci&oacute;n</td>
						<td><input type="text" id="dircli" name="dircli" required></td>
						<td>Tel&eacute;fono</td>
						<td><input type="text" id="telcli" name="telcli" required></td>
					</tr>
					<tr>
						<td>Departamento</td>
						<td><select id="dep" name="dep" onchange="cargarPobs(this.id,'pob');" style="width:10rem;"></select></td>
						<td>Municipio/Poblaci&oacute;n</td>
						<td><select id="pob" name="pob" style="width:10rem;"></select></td>
					</tr>
					<tr>
						<td colspan="4" style="text-align: center;">
							<input type="button" value="Enviar" onclick="registrarCliente('frmregcli');">
						</td>
					</tr>
				</table>
			</form>
		</div><!--tab2-->
	</div><!--tabcontainer-->
	<div style="clear:both;"></div>
</div>
