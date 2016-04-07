<?php
	require_once("../objetos/conexion.php");
	
	class FacturaModelo{
		public function __construct() {
			
		}
		
		public function ingresarFactura($idcl,$val,$ffac,$fven,$desc){
			$cad = "";
			$sql = "INSERT INTO factura(idcliente,valor,fecha,fechalimite,idusuario,descripcion,activo) VALUES ($idcl,$val,'$ffac','$fven',".$_SESSION['pid'].",'$desc',1)";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("Ew0x3: ".mysql_error());
				$filas = mysql_affected_rows();
				$idf = mysql_insert_id();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada|$idf";
				else $cad = "No fue posible insertar la informacion";
			}
			catch (Exception $exc) {
				echo "facturaModelo.php - Ej85q: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function ingresarCuentaxCobrar($idfactura){
			$cad = "";
			$sql = "INSERT INTO cuentasporcobrar(idfactura,activo) VALUES ($idfactura,1)";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("Eg0x5: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Creado registro de cuenta x cobrar";
				else $cad = "No fue posible crear registro de cuenta x cobrar";
			}
			catch (Exception $exc) {
				echo "facturaModelo.php - Epz4s: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function ingresarCuentaxPagar($idfactura){
			$cad = "";
			$sql = "INSERT INTO cuentasporpagar(idfactura,activo) VALUES ($idfactura,1)";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("Ed7b: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Creado registro de cuenta x pagar";
				else $cad = "No fue posible crear registro de cuenta x pagar";
			}
			catch (Exception $exc) {
				echo "facturaModelo.php - Eq03a: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function verFacturasCliente($idcli){
			$json = '{"facturas":[';
			$cnt = 0;
			$sql = "SELECT * FROM factura WHERE idcliente=$idcli ";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E3jq: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						if($cnt!=0){
							$json .= ",";
						}
						else{
							$cnt=1;
						}
						$json .= '{"id":"'.$row['id'].'","valor":"'.number_format($row['valor'],2,'.',',').'","fechap":"'.$row['fecha'].'","fechav":"'.$row['fechalimite'].'","desc":"'.$row['descripcion'].'","activo":"'.$row['activo'].'"}';
					}
				}
				else{
					$json .= '{"id":"","valor":"0","fechap":"","fechav":"","desc":"","activo":"0"}';
				}
			}
			catch (Exception $exc) {
				echo "facturaModelo.php - E1f40: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			$json .= ']}';
			return $json;
		}
		
		public function verFacturasPorPagar(){
			$json = '{"facturas":[';
			$cnt = 0;
			$sql = 
			"SELECT f.*, CONCAT(cl.nombres,' ',cl.apellidos) AS nombrecl
			FROM factura f 
			INNER JOIN cuentasporpagar cxp ON f.id=cxp.idfactura
			INNER JOIN cliente c ON c.id=f.idcliente
			LEFT JOIN comprobantefactura cf ON f.id=cf.idfactura
			WHERE cf.idfactura IS NULL
			AND cxp.activo=1 AND f.activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Ewe6: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						if($cnt!=0){
							$json .= ",";
						}
						else{
							$cnt=1;
						}
						$json .= '{"id":"'.$row['id'].'","valor":"'.$row['valor'].'"
						,"fechap":"'.$row['fecha'].'","fechav":"'.$row['fechalimite'].'"
						,"cliente":"'.trim($row['nombrecl']).'"
						,"desc":"'.$row['descripcion'].'","activo":"'.$row['activo'].'"}';
					}
				}
				else{
					$json .= '{"id":"","valor":"0","fechap":"","fechav":"","cliente":"","desc":"","activo":"0"}';
				}
			}
			catch (Exception $exc) {
				echo "facturaModelo.php - E6fd: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			$json .= ']}';
			return $json;
		}
		
		public function verDetallesFactura($idf){
			$cad = "";
			$sql = 
			"SELECT f.*, CONCAT(cl.nombres,' ',cl.apellidos) AS nombrecl, COALESCE(cf.idcomprobante,0) AS numcomprobante
			FROM factura f 
			INNER JOIN cliente cl ON cl.id=f.idcliente
			LEFT JOIN comprobantefactura cf ON f.id=cf.idfactura
			WHERE f.id=$idf AND f.activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Ey5sd: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .= "".$row['id']."|".$row['valor']."|".$row['fecha']."|".$row['fechalimite']
						."|".trim($row['nombrecl'])."|".$row['descripcion']."|".$row['activo']."|".$row['numcomprobante'];
					}
				}
				else{
					$cad = "0|No encontrada";
				}
			}
			catch (Exception $exc) {
				echo "facturaModelo.php - Eo8s5: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function tipoFactura($idf){
			$cad = "0|No definido";
			$sql = 
			"SELECT 1 AS tabla, 'Cuenta x cobrar' AS tipofact
			FROM cuentasporcobrar
			WHERE idfactura = $idf
			UNION
			SELECT 2 AS tabla, 'Cuenta x pagar' AS tipofact
			FROM cuentasporpagar
			WHERE idfactura = $idf";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Ec8sr: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad = "".$row['tabla']."|".$row['tipofact'];
					}
				}
				else{
					$cad = "0|No encontrada";
				}
			}
			catch (Exception $exc) {
				echo "facturaModelo.php - E5rs9: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function valorPagadoFactura($idf){
			$valor = 0.00;
			$tipof = $this->tipoFactura($idf);
			$tf = explode("|",$tipof);
			$tbl = "cuentasporcobrar";
			$tipoc = "1,4";
			if($tf[0]==1){
				$tbl = "cuentasporcobrar";
				$tipoc = "1,4";
			}
			if($tf[0]==2){
				$tbl = "cuentasporpagar";
				$tipoc = "2,3";
			}
			$sql = 
			"SELECT COALESCE(SUM(cp.valor),0.00) AS pagado
			FROM comprobantefactura cf
			INNER JOIN comprobante cp ON cf.idcomprobante=cp.id
			INNER JOIN $tbl cxcp ON cxcp.idfactura=cf.idfactura
			WHERE cf.idfactura=$idf AND cp.tipo_comprobante IN ($tipoc) AND cxcp.activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E6rg3: ".mysql_error());
				$con->desconectar();
				while($row = mysql_fetch_array($result)){
					$valor = $row['pagado'];
				}
			}
			catch (Exception $exc) {
				echo "facturaModelo.php - E0s3d: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $valor;
		}
		
		public function comprobantesFactura($idf){
			$cad = "";
			$sql = 
			"SELECT tc.nombre AS tipoc, cp.valor, cp.fecha, CONCAT(ct.codigo,'-',ct.nombre) AS ncuenta,ts.nombre AS tsoporte,cp.numerosoporte
			FROM comprobantefactura cf 
			INNER JOIN comprobante cp ON cf.idcomprobante = cp.id
			INNER JOIN tipocomprobante tc ON cp.tipo_comprobante = tc.id
			INNER JOIN cuenta ct ON cp.idcuenta = ct.id
			INNER JOIN tiposoporte ts ON cp.tiposoporte = ts.id
			WHERE cf.idfactura= $idf";
			$cnt = 0;
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Ec8sr: ".mysql_error());
				$con->desconectar();
				while($row = mysql_fetch_array($result)){
					if($cnt==0){
						$cnt = 1;
					}
					else{
						$cad .= ";_;";
					}
					$cad .= "".$row['tipoc']."|".$row['valor']."|".$row['fecha']."|".$row['ncuenta']."|".$row['tsoporte']."|".$row['numerosoporte'];
				}
			}
			catch (Exception $exc) {
				echo "facturaModelo.php - E5rs9: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function facturasClienteAcreedorOption($idtipo,$idcli){
			$cad = "";
			$join = "";
			if($idtipo==1){
				$join = "cobrar";
			}
			if($idtipo==2){
				$join = "pagar";
			}
			$sql = "SELECT f.* 
			FROM cliente cl INNER JOIN factura f ON cl.id=f.idcliente 
			INNER JOIN cuentaspor$join cxcp ON f.id=cxcp.idfactura
			WHERE cl.activo=1 AND cl.id=$idcli AND f.activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Ey01g: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .=  "<option value='".$row['id']."'>valor: $ ".number_format($row['valor'],2,'.',',').", fecha: ".$row['fecha']."</option>";
					}
				}
				else{
					$cad = "";
				}
			}
			catch (Exception $exc) {
				echo "clienteModelo.php - E9zx0: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function tipoSoporteSelect(){
			$cad="";
			$sql = "SELECT * FROM tiposoporte WHERE activo=1 ";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E37sW: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .= "<option value='".$row['id']."'>".$row['nombre']."</option>";
					}
				}
			}
			catch (Exception $exc) {
				echo "menuModelo.php - EU7sv: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function tipoComprobanteSelect(){
			$cad="";
			$sql = "SELECT * FROM tipocomprobante WHERE activo=1 ";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Eq6sW: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .= "<option value='".$row['id']."'>".$row['nombre']."</option>";
					}
				}
			}
			catch (Exception $exc) {
				echo "menuModelo.php - Ed7Hv: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function ingresarPago($fact,$tipo,$val,$cuenta,$numsoporte,$fechapago,$tiposop){
			$cad = "";
			$sql = "INSERT INTO comprobante(tipo_comprobante,valor,idcuenta,fecha,tiposoporte,numerosoporte,activo) 
			VALUES ($tipo,$val,$cuenta,'$fechapago',$tiposop,'$numsoporte',1)";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("E7Gb: ".mysql_error());
				$idcom = mysql_insert_id();
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0){
					$cad = "Creado registro de pago de factura";
					$con->conectar();
					mysql_query("INSERT INTO comprobantefactura(idcomprobante,idfactura,activo) VALUES ($idcom,$fact,1)") or die("EF5sb: ".mysql_error());
					if(mysql_affected_rows() > 0) $cad = "Creado registro de pago de factura";
					else $cad = "No fue posible crear registro de comprobante de pago de factura";
				}
				else $cad = "No fue posible crear registros de pago de factura";
			}
			catch (Exception $exc) {
				echo "facturaModelo.php - Eq03D: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
	}
?>
