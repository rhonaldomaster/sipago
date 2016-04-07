<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
?>
<script>
	function verFactura(idf,iddiv){
		$.post("./scripts/facturaControl.php",{opcion:4,id:idf},function(resp){
			$("#"+iddiv).html(resp);
		});
	}
	function facturasPorPagar(iddiv){
		$.getJSON("./scripts/facturaControl.php",{opcion:3},function(data){
			if(data.facturas[0]!=null){
				var html1 = "<table id='tblfact' class='tablesorter' cellspacing='0'>";
				html1 += "<thead><tr><th class='header'>Acreedor</th><th class='header'>Valor</th><th class='header'>Fecha</th><th class='header'>Fecha venc.</th><th class='header'>Activo</th>";
				/*if(accion==2){
					html1 += "<th class='header'>Acci&oacute;n</th>";
				}*/
				html1 += "</tr><thead><tbody></tbody><tfoot></tfoot></table>";
				$("#"+iddiv).html(html1);
				$.each(data.facturas, function(i,factura){
					var html2 = "";
					html2 = "<tr>";
					if(factura.id==""){
						var cspan = 5;
						if(accion==2){
							cspan=6;
						}
						html2 += "<td colspan='"+cspan+"' style='text-align: center;'>No se encontraron resultados</td>";
					}
					else{
						html2 += "<td style='text-align:right;'>$ "+factura.cliente+"</td>";
						html2 += "<td style='text-align:right;'>$ "+factura.valor+"</td>";
						html2 += "<td style='text-align:right;'>"+factura.fechap+"</td>";
						html2 += "<td style='text-align:right;'>"+factura.fechav+"</td>";
						html2 += "<td>"+( (factura.activo==1) ? "S&iacute;":"No")+"</td>";
						/*if(accion==2){
							html2 += "<td><input type='image' title='Editar' src='./img/icn_edit.png' onclick='editarFactura("+factura.id+");' alt='Editar'>";
							html2 += " <input type='image' title='Desactivar' src='./img/icn_trash.png' onclick='desactivarFactura("+factura.id+");' alt='Borrar'></td>";
						}*/
					}
					html2 += "</tr>";
					$("#tblfact tbody").append(html2);
					$(".tablesorter").tablesorter();
				});
			}
			else{
				jAlert("Ocurri\u00F3 un problema al obtener los datos","Error");
			}
		});
	}
	$(document).ready(function(){
		facturasPorPagar("factpag");
	});
</script>
<div id="factpag"></div>
