<?php
	
	require_once("../objetos/conexion.php");
	require_once("../objetos/usuario.php");
	
	class UsuarioModelo{
		
		public function __construct() {
			
		}
		
		public function buscarPorId($idu){
			$usu = "uu";
			$sql = 
			"SELECT u.*
			FROM usuario u
			WHERE u.id=$idu";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Error al consultar".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$usu = new Usuario();
						$usu->setId($idu);
						$usu->setNombres($row['nombres']);
						$usu->setApellidos($row['apellidos']);
					}
				}
				else{
					$usuario = new Usuario($idu,"","");
				}
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - E1bpd: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $usu;
		}
		
		public function verificarLogin($u,$p){
			$resp = "No registrado";
			$cl = md5($p);
			$sql = 
			"SELECT u.*
			FROM usuario u
			WHERE u.username='$u' AND clave='$cl' ";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Error al consultar:".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					$resp = "ok";
					while($row = mysql_fetch_array($result)){
						$_SESSION['pid'] = $row['id'];
					}
				}
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - E1b4s: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $resp;
		}
		
		public function tipoIdentificacion_Option(){
			$resp = "";
			$sql = "SELECT * FROM tipoIdentificacion WHERE activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Error al consultar:".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$resp .= "<option value='".$row['id']."'>".$row['nombre']."</option>";
					}
				}
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - E1b4s: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			echo $resp;
		}
		
		public function buscarUsuarios(){
			$json = '{"usuarios":[';
			$sql = 
			"SELECT u.*
			FROM usuario u";
			$con = new Conexion();
			$cnt=0;
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Ec82s3: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						if($cnt!=0){
							$json .= ",";
						}
						else{
							$cnt=1;
						}
						$json .= '{"id":"'.$row['id'].'","identificacion":"'.$row['identificacion'].'","nombres":"'.$row['nombres'].'","apellidos":"'.$row['apellidos'].'","activo":"'.$row['activo'].'"}';
					}
				}
				else{
					$json .= '{"id":"","identificacion":"","nombres":"","apellidos":"","activo":"0"}';
				}
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - E714a5: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			$json.=']}';
			return $json;
		}
		
		public function buscarUsuarioPorId($id){
			$cad = "";
			$sql = "SELECT * FROM usuario WHERE id=$id ";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E252sd: ".mysql_error());
				$con->desconectar();
				while($row = mysql_fetch_array($result)){
					$cad = $row['tipo_identificacion']."|".$row['identificacion']."|".$row['nombres']."|".$row['apellidos']."|".$row['telefono']."|".$row['direccion']."|".$row['email']."|".$row['username'];
				}
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - E02swd: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function desactivarUsuario($id){
			$cad = "";
			$sql = "UPDATE usuario SET activo=0 WHERE id=$id ";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("E8s0q: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - Eg59e: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		function modificarUsuario($id,$tipoid,$numid,$nom,$ape,$tel,$dir,$mail,$usr){
			$cad = "";
			$sql = "UPDATE usuario SET tipo_identificacion=$tipoid,identificacion=$numid
			,nombres='$nom',apellidos='$ape',telefono='$tel'
			,direccion='$dir',email='$mail',username='$usr' WHERE id=$id";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("E3tb8: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - E93da: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		function crearUsuario($tipoid,$numid,$nom,$ape,$tel,$dir,$mail,$usr,$cla){
			$cad = "";
			$sql = "INSERT INTO usuario(tipo_identificacion,identificacion,nombres,apellidos,telefono,direccion,email,username,clave,activo) 
			VALUES ( $tipoid,$numid,'$nom','$ape','$tel','$dir','$mail','$usr','$cla',1 )";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("Efd5d5: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - Es2f1: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		function modificarClave($idu,$cla){
			$cad = "";
			$sql = "UPDATE usuario SET clave='$cla' WHERE id=$idu";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("Er03tt: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - E8w21: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function buscarPerfiles(){
			$json = '{"perfiles":[';
			$sql = 
			"SELECT u.*
			FROM perfil u";
			$con = new Conexion();
			$cnt=0;
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Ew7l4: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						if($cnt!=0){
							$json .= ",";
						}
						else{
							$cnt=1;
						}
						$json .= '{"id":"'.$row['id'].'","nombre":"'.$row['nombre'].'","activo":"'.$row['activo'].'"}';
					}
				}
				else{
					$json = '{"id":"","nombre":"","activo":"0"}';
				}
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - E7dc0: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			$json.=']}';
			return $json;
		}
		
		public function desactivarPerfil($id){
			$cad = "";
			$sql = "UPDATE perfil SET activo=0 WHERE id=$id ";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("E3s40: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - Eo0a1: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function datosPerfil($id){
			$cad = "";
			$sql = "SELECT id,nombre,activo FROM perfil WHERE id=$id ";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E720x: ".mysql_error());
				$con->desconectar();
				while($row = mysql_fetch_array($result)){
					$cad = $row['nombre']."|".$row['activo'];
				}
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - Ew7f: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function crearPerfil($nom){
			$cad = "";
			$sql = "INSERT INTO perfil(nombre,activo) 
			VALUES ( '$nom',1 )";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("Exc0q: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - E3av02: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function actualizarPerfil($id,$nom,$act){
			$cad = "";
			$sql = "UPDATE prefil SET nombre='$nom',activo=$act WHERE id=$id";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("E3tb8: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - E93da: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function listadoUsuario_Option(){
			$cad = "";
			$sql = "SELECT * FROM usuario WHERE activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E7F0d: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .=  "<option value='".$row['id']."'>".utf8_encode($row['nombres']." ".$row['apellidos'])."</option>";
					}
				}
				else{
					$cad = "";
				}
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - ETd04: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function listadoPerfiles_Option(){
			$cad = "";
			$sql = "SELECT * FROM perfil WHERE activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E0w1zs: ".mysql_error());
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
				echo "usuarioModelo.php - Er0sw: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function asignarPerfil($idu,$idp){
			$cad = "";
			$sql = "INSERT INTO perfilusuario(idusuario,idperfil,activo) 
			VALUES ( $idu,$idp,1 )";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("Eps10: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - E6z0q: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function quitarPerfil($idu,$idp){
			$cad = "";
			$sql = "DELETE FROM perfilusuario WHERE idusuario=$idu AND idperfil=$idp )";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("Eps10: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "usuarioModelo.php - E6z0q: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function listadoPerfilesUsuario_Option($idu){
			$cad = "";
			$sql = "SELECT pf.* 
			FROM perfil pf 
			INNER JOIN perfilusuario pu ON pu.idperfil=pf.id 
			WHERE pu.activo=1 AND pu.idusuario=$idu";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E31sd: ".mysql_error());
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
				echo "clienteModelo.php - E3y7x: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function perfilesUsuarios(){
			$sql = "SELECT CONCAT( u.nombres, ' ', u.apellidos ) AS nombreUsuario, pf.nombre AS nombrePerfil
			FROM perfilusuario pu
			INNER JOIN perfil pf ON pu.idperfil = pf.id
			INNER JOIN usuario u ON pu.idusuario = u.id
			WHERE pu.activo =1";
		}
	}
?>
