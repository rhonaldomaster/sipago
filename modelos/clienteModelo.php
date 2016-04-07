<?php
	require_once("../objetos/conexion.php");
	
	class ClienteModelo{
		public function __construct() {
			
		}
		
		public function buscarClientes(){
			$json = '{"clientes":[';
			$sql = "SELECT * FROM cliente";
			$cnt=0;
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Ez5a0Q: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						if($cnt!=0){
							$json .= ",";
						}
						else{
							$cnt=1;
						}
						$json .= '{"id":"'.$row['id'].'","nombres":"'.$row['nombres'].'","apellidos":"'.$row['apellidos'].'","identificacion":"'.$row['identificacion'].'","activo":"'.$row['activo'].'"}';
					}
				}
				else{
					$json .= '{"id":"","nombres":"","apellidos":"","identificacion":"","activo":"0"}';
				}
			}
			catch (Exception $exc) {
				echo "clienteModelo.php - Ey9Sx: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			$json.=']}';
			return $json;
		}
		
		public function listadoClientes_Option(){
			$cad = "";
			$sql = "SELECT * FROM cliente WHERE activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Eq41x: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .=  "<option value='".$row['id']."'>".trim(utf8_encode($row['nombres']." ".$row['apellidos']))."</option>";
					}
				}
				else{
					$cad = "";
				}
			}
			catch (Exception $exc) {
				echo "clienteModelo.php - Ev4l2m: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function listadoClientesTipo_Option($idtipo){
			$cad = "";
			$join = "";
			if($idtipo==1){
				$join = "cobrar";
			}
			if($idtipo==2){
				$join = "pagar";
			}
			$sql = "SELECT cl.* 
			FROM cliente cl INNER JOIN factura f ON cl.id=f.idcliente 
			INNER JOIN cuentaspor$join cxcp ON f.id=cxcp.idfactura
			WHERE cl.activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Eqw7x: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .=  "<option value='".$row['id']."'>".trim(utf8_encode($row['nombres']." ".$row['apellidos']))."</option>";
					}
				}
				else{
					$cad = "";
				}
			}
			catch (Exception $exc) {
				echo "clienteModelo.php - E7ob2: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function desactivarCliente($id){
			$cad = "";
			$sql = "UPDATE cliente SET activo=0 WHERE id=$id ";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("E8s5A: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "clienteModelo.php - Ef5Sx0: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function modificarCliente($id,$tipoid,$iden,$nom,$ape,$dir,$tel,$idmun){
			$cad = "";
			$sql = "UPDATE cliente SET apellidos='$ape',nombres='$nom',identificacion=$iden ,tipo_identificacion=$tipoid WHERE id=$id ";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("Ew88va: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion basica";
				$cad .= $this->registrarDireccionCliente($id,$dir,$idmun);
				$cad .= $this->registrarTelefonoCliente($id,$tel);
			}
			catch (Exception $exc) {
				echo "clienteModelo.php - E61dF: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function verSiExisteDireccion($id,$dir,$idmun){
			$existe = false;
			$sql = "SELECT cl.* 
			FROM cliente cl INNER JOIN direcciones d ON cl.id=d.idcliente 
			WHERE cl.id=$id AND d.direccion='$dir' AND idmunicipio=$idmun AND d.activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Ek6Ad: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					$existe = true;
				}
			}
			catch (Exception $exc) {
				echo "clienteModelo.php - E9s5Fs: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $existe;
		}
		
		public function registrarDireccionCliente($id,$dir,$idmun){
			if($this->verSiExisteDireccion($id,$dir,$idmun)==false){
				$cad = "";
				$sql = "INSERT INTO direcciones(idcliente,direccion,idmunicipio,activo) VALUES ($id,'$dir',$idmun,1)";
				$con = new Conexion();
				try{
					$con->conectar();
					mysql_query($sql) or die("E10Q4a: ".mysql_error());
					$filas = mysql_affected_rows();
					$con->desconectar();
					if ($filas>0) $cad = "\nDireccion actualizada";
					else $cad = "\nNo fue posible insertar la informacion de direccion";
				}
				catch (Exception $exc) {
					echo "clienteModelo.php - Ew68Kb0: ".$exc->getTraceAsString();
					$con->desconectar();
				}
				return $cad;
			}
		}
		
		public function verSiExisteTelefono($id,$tel){
			$existe = false;
			$sql = "SELECT cl.* 
			FROM cliente cl INNER JOIN telefonos t ON cl.id=t.idcliente 
			WHERE cl.id=$id AND t.telefono='$tel' AND t.activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("ErT74d: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					$existe = true;
				}
			}
			catch (Exception $exc) {
				echo "clienteModelo.php - Efr4p5A: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $existe;
		}
		
		public function registrarTelefonoCliente($id,$tel){
			if($this->verSiExisteTelefono($id,$tel)==false){
				$cad = "";
				$sql = "INSERT INTO telefonos(idcliente,telefono,activo) VALUES ($id,'$tel',1)";
				$con = new Conexion();
				try{
					$con->conectar();
					mysql_query($sql) or die("E905sD: ".mysql_error());
					$filas = mysql_affected_rows();
					$con->desconectar();
					if ($filas>0) $cad = "\nTelefono actualizado";
					else $cad = "\nNo fue posible insertar la informacion de telefono";
				}
				catch (Exception $exc) {
					echo "clienteModelo.php - ETe7sA: ".$exc->getTraceAsString();
					$con->desconectar();
				}
				return $cad;
			}
		}
		
		public function buscarClientePorId($id){
			$cad = "";
			$sql = "SELECT cl.*,COALESCE(tl.telefono,0) AS telefono
			,COALESCE(dr.direccion,'') AS direccion,COALESCE(dr.idmunicipio,0) AS idmunicipio,COALESCE(mp.codigodep,0) AS codigodep
			FROM cliente cl 
			LEFT JOIN direcciones dr ON dr.idcliente=cl.id AND dr.activo=1
			LEFT JOIN telefonos tl ON tl.idcliente=cl.id AND tl.activo=1
			LEFT JOIN municipio mp ON mp.id=dr.idmunicipio
			WHERE cl.id=$id ";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E4Wd7: ".mysql_error());
				$con->desconectar();
				while($row = mysql_fetch_array($result)){
					$cad = $row['apellidos']."|".$row['nombres']."|".$row['identificacion']
					."|".$row['tipo_identificacion']."|".$row['direccion']
					."|".$row['idmunicipio']."|".$row['codigodep']."|".$row['telefono'];
				}
			}
			catch (Exception $exc) {
				echo "clienteModelo.php - Ez05ab: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function ingresarCliente($nom,$ape,$iden,$tipoid,$dir,$tel,$idmun){
			$cad = "";
			$sql = "INSERT INTO cliente(nombres,apellidos,identificacion,tipoid) VALUES ('$nom','$ape',$iden,$tipoid)";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("E95qr: ".mysql_error());
				$filas = mysql_affected_rows();
				$id = mysql_insert_id();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible insertar la informacion";
				$cad .= $this->registrarTelefonoCliente($id,$tel);
				$cad .= $this->registrarDireccionCliente($id,$dir,$idmun);
			}
			catch (Exception $exc) {
				echo "clienteModelo.php - Ea01s6: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function listaTipoId_Option(){
			$cad = "";
			$sql = "SELECT * FROM tipoIdentificacion WHERE activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Eu8sa: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .=  "<option value='".$row['id']."'>".utf8_encode($row['nombre'])."</option>";
					}
				}
				else{
					$cad = "";
				}
			}
			catch (Exception $exc) {
				echo "clienteModelo.php - Ek41i: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function listaDepartamentos_Option(){
			$cad = "";
			$sql = "SELECT * FROM departamento";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Ep8Asa: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .=  "<option value='".$row['codigodep']."'>".utf8_encode($row['nombredep'])."</option>";
					}
				}
				else{
					$cad = "";
				}
			}
			catch (Exception $exc) {
				echo "clienteModelo.php - Ebk1l4: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function listaPoblaciones_Option($iddp){
			$cad = "";
			$sql = "SELECT * FROM municipio WHERE codigodep='$iddp' ";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Ej0d3: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .=  "<option value='".$row['id']."'>".utf8_encode($row['nombrepob'])."</option>";
					}
				}
				else{
					$cad = "";
				}
			}
			catch (Exception $exc) {
				echo "clienteModelo.php - Ev34sA: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function listaDepartamentos_OptionSel($iddp){
			$cad = "";
			$sql = "SELECT * FROM departamento";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Ee7a1: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$sel = "";
						if(strcasecmp($row['codigodep'],$iddp)==0) $sel = " selected";
						$cad .=  "<option value='".$row['codigodep']."'$sel>".utf8_encode($row['nombredep'])."</option>";
					}
				}
				else{
					$cad = "";
				}
			}
			catch (Exception $exc) {
				echo "clienteModelo.php - Ej7Sc: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function listaPoblaciones_OptionSel($iddp,$idm){
			$cad = "";
			$sql = "SELECT * FROM municipio WHERE codigodep='$iddp' ";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Eq26xD: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$sel = "";
						if($row['id']==$idm) $sel = " selected";
						$cad .=  "<option value='".$row['id']."'$sel>".utf8_encode($row['nombrepob'])."</option>";
					}
				}
				else{
					$cad = "";
				}
			}
			catch (Exception $exc) {
				echo "clienteModelo.php - EgA0s8: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
	}
?>
