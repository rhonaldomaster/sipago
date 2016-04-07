<?php
	require_once("../objetos/conexion.php");
	
	class CuentasModelo{
		public function __construct() {
			
		}
		
		public function areasPUC_Option(){
			$cad = "";
			$sql = "SELECT * FROM areacuenta WHERE activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E3d7H: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .=  "<option value='".$row['id']."'>".$row['codigo']."-".utf8_encode($row['nombre'])."</option>";
					}
				}
				else{
					$cad = "";
				}
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E7fr4: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function subgruposPUC_Option($ida){
			$cad = "";
			$sql = "SELECT * FROM grupocuenta WHERE activo=1 AND idarea=$ida";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E3g7H: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .=  "<option value='".$row['id']."'>".$row['codigo']."-".utf8_encode($row['nombre'])."</option>";
					}
				}
				else{
					$cad = "";
				}
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E8fr4: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function ingresarCuenta($ida,$idg,$cod,$nom){
			$cad = "";
			$sql = "INSERT INTO cuenta(idarea,idgrupo,codigo,nombre) VALUES ($ida,$idg,$cod,'$nom')";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("E7o7H: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible insertar la informacion";
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E1hr4: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		function buscarCuentasPorAreaYGrupo($ida,$idg){
			$json = '{"cuentas":[';
			$cnt = 0;
			$sql = "SELECT * FROM cuenta WHERE idarea=$ida AND idgrupo=$idg ";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E7oe8: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						if($cnt!=0){
							$json .= ",";
						}
						else{
							$cnt=1;
						}
						$json .= '{"id":"'.$row['id'].'","codigo":"'.$row['codigo'].'","nombre":"'.$row['nombre'].'","activo":"'.$row['activo'].'"}';
					}
				}
				else{
					$json .= '{"id":"","codigo":"","nombre":"","activo":"0"}';
				}
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E1g44: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			$json.=']}';
			return $json;
		}
		
		public function buscarCuentaPorId($id){
			$cad = "";
			$sql = "SELECT * FROM cuenta WHERE id=$id ";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E8gvH: ".mysql_error());
				$con->desconectar();
				while($row = mysql_fetch_array($result)){
					$cad = $row['codigo']."|".$row['nombre'];
				}
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E1hd4: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function desactivarCuenta($id){
			$cad = "";
			$sql = "UPDATE cuenta SET activo=0 WHERE id=$id ";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("E0a2: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "cuentasModelo.php - Ew95w: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function modificarCuenta($id,$cod,$nom){
			$cad = "";
			$sql = "UPDATE cuenta SET codigo=$cod,nombre='$nom' WHERE id=$id ";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("Eq4101: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "cuentasModelo.php - E85ds: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		function buscarCuentasPorAreaYGrupoSelect($ida,$idg){
			$cad="";
			$sql = "SELECT * FROM cuenta WHERE idarea=$ida AND idgrupo=$idg ";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E9E0s: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .= "<option value='".$row['id']."'>".$row['codigo']."-".$row['nombre']."</option>";
					}
				}
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E6q1U: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
	}
?>
