<?php
	require_once("../objetos/conexion.php");
	
	class ContabilidadModelo{
		public function __construct() {
			
		}
		
		public function verTransaccionesDia($fecha){
			$cad = "";
			$cad = "<table class='tablesorter'><caption>Movimientos del d&iacute;a $fecha</caption>";
			$cad .= 
				"<thead>"
					."<tr>"
						."<th>Cuenta</th>"
						."<th>Ingreso</th>"
						."<th>Egreso</th>"
						."<th>Tipo comprob.</th>"
						."<th>No. comprob.</th>"
						."<th>Tipo soporte</th>"
						."<th>No. soporte</th>"
						."<th>Comentarios</th>"
					."</tr>"
				."</thead>"
				."<tbody>";
			$sql = 
			"SELECT c.id,COALESCE(cf.comentario,'') AS comentario,CASE WHEN tc.clase=1 THEN c.valor ELSE 0 END AS vdebe
				,CASE WHEN tc.clase=2 THEN c.valor ELSE 0 END AS vhaber
				,c.numerosoporte,CONCAT(cu.codigo,'-',cu.nombre) AS ncuenta
				,tc.nombre AS ntipocomprobante,ts.nombre AS ntiposoporte
			FROM comprobante c
			INNER JOIN cuenta cu ON cu.id=c.idcuenta
			INNER JOIN tipocomprobante tc ON tc.id=c.tipo_comprobante
			INNER JOIN tiposoporte ts ON ts.id=c.tiposoporte
			LEFT JOIN comprobantefactura cf ON (cf.idcomprobante=c.id AND cf.activo=1)
			WHERE c.fecha='$fecha' AND c.activo=1 ";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("EP5d41: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					$sum1 = 0;
					$sum2 = 0;
					while($row = mysql_fetch_array($result)){
						$cad .="<tr>";
						$cad .=  "<td>".$row['ncuenta']."</td>";
						$cad .=  "<td style='text-align:right;'>$ ".number_format($row['vdebe'],2,'.',',')."</td>";
						$cad .=  "<td style='text-align:right;'>$ ".number_format($row['vhaber'],2,'.',',')."</td>";
						$cad .=  "<td>".$row['ntipocomprobante']."</td>";
						$cad .=  "<td>".$row['id']."</td>";
						$cad .=  "<td>".$row['ntiposoporte']."</td>";
						$cad .=  "<td>".$row['numerosoporte']."</td>";
						$cad .=  "<td>".$row['comentario']."</td>";
						$cad .="</tr>";
						$sum1 += $row['vdebe'];
						$sum2 += $row['vhaber'];
					}
					$balance = $sum1 - $sum2;
					$stl = "";
					if($balance>0) $stl = " color: #6495ED;";
					else if($balance==0) $stl = " color: #9ACD32;";
					else if($balance<0) $stl = " color: #EE2C2C;";
					$cad .= "<tr>"
						."<th>Totales</th>"
						."<td style='text-align:right;'>$ ".number_format($sum1,2,'.',',')."</td>"
						."<td style='text-align:right;'>$ ".number_format($sum2,2,'.',',')."</td>"
						."<th>Balance</th>"
						."<td style='text-align:right;$stl'>$ ".number_format($balance,2,'.',',')."</td>"
						."<td colspan='4'></td>"
					."</tr>";
				}
				else{
					$cad .= "<tr><td colspan='8' style='text-align:center;'>No hay resultados</td></tr>";
				}
			}
			catch (Exception $exc) {
				echo "contabilidadModelo.php - E0W7s: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			$cad .= "</tbody></table>";
			return $cad;
		}
		
		public function verTransaccionesMes($anio,$mes){
			$cad = "";
			$cad = "<table class='tablesorter'><caption>Movimientos de la fecha $anio-$mes</caption>";
			$cad .= 
				"<thead>"
					."<tr>"
						."<th>Fecha</th>"
						."<th>Cuenta</th>"
						."<th>Ingreso</th>"
						."<th>Egreso</th>"
						."<th>Tipo comprob.</th>"
						."<th>No. comprob.</th>"
						."<th>Tipo soporte</th>"
						."<th>No. soporte</th>"
						."<th>Comentarios</th>"
					."</tr>"
				."</thead>"
				."<tbody>";
			$sql = 
			"SELECT c.id,COALESCE(cf.comentario,'') AS comentario,CASE WHEN tc.clase=1 THEN c.valor ELSE 0 END AS vdebe
				,CASE WHEN tc.clase=2 THEN c.valor ELSE 0 END AS vhaber
				,c.numerosoporte,CONCAT(cu.codigo,'-',cu.nombre) AS ncuenta
				,tc.nombre AS ntipocomprobante,ts.nombre AS ntiposoporte,c.fecha
			FROM comprobante c
			INNER JOIN cuenta cu ON cu.id=c.idcuenta
			INNER JOIN tipocomprobante tc ON tc.id=c.tipo_comprobante
			INNER JOIN tiposoporte ts ON ts.id=c.tiposoporte
			LEFT JOIN comprobantefactura cf ON (cf.idcomprobante=c.id AND cf.activo=1)
			WHERE c.fecha LIKE '$anio-$mes-%' AND c.activo=1 ";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E9qA0s: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					$sum1 = 0;
					$sum2 = 0;
					while($row = mysql_fetch_array($result)){
						$cad .="<tr>";
						$cad .=  "<td>".$row['fecha']."</td>";
						$cad .=  "<td>".$row['ncuenta']."</td>";
						$cad .=  "<td style='text-align:right;'>$ ".number_format($row['vdebe'],2,'.',',')."</td>";
						$cad .=  "<td style='text-align:right;'>$ ".number_format($row['vhaber'],2,'.',',')."</td>";
						$cad .=  "<td>".$row['ntipocomprobante']."</td>";
						$cad .=  "<td>".$row['id']."</td>";
						$cad .=  "<td>".$row['ntiposoporte']."</td>";
						$cad .=  "<td>".$row['numerosoporte']."</td>";
						$cad .=  "<td>".$row['comentario']."</td>";
						$cad .="</tr>";
						$sum1 += $row['vdebe'];
						$sum2 += $row['vhaber'];
					}
					$balance = $sum1 - $sum2;
					$stl = "";
					if($balance>0) $stl = " color: #6495ED;";
					else if($balance==0) $stl = " color: #9ACD32;";
					else if($balance<0) $stl = " color: #EE2C2C; font-weight: bold;";
					$cad .= "<tr>"
						."<th colspan='2'>Totales</th>"
						."<td style='text-align:right;'>$ ".number_format($sum1,2,'.',',')."</td>"
						."<td style='text-align:right;'>$ ".number_format($sum2,2,'.',',')."</td>"
						."<th>Balance</th>"
						."<td style='text-align:right;$stl'>$ ".number_format($balance,2,'.',',')."</td>"
						."<td colspan='4'></td>"
					."</tr>";
				}
				else{
					$cad .= "<tr><td colspan='9' style='text-align:center;'>No hay resultados</td></tr>";
				}
			}
			catch (Exception $exc) {
				echo "contabilidadModelo.php - E5k3ss: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			$cad .= "</tbody></table>";
			return $cad;
		}
	}
?>
