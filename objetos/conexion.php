<?php	
	/**
	*	Clase para el manejo de las conexiones del sistema
	*	@author Rhonalf Martinez (rhonaldomaster@gmail.com)
	*	@copy GNU/GPL v3
	*/
	class Conexion {
        
		private $dbhost = "";
		private $dbname = "";
		private $dbuser = "";
		private $dbpasswd = "";
		private $link;

		public function __construct() {
			$this->dbhost = "localhost";
			$this->dbname = "sipago";
			$this->dbuser = "sipago_user";
			$this->dbpasswd = "sipago_password";
		}

		public function conectar() {
			$this->link =  mysql_connect($this->dbhost,$this->dbuser,$this->dbpasswd) or die ('Ha fallado la conexi&#243;n: '.mysql_error());
			mysql_select_db($this->dbname) or die ('Error al seleccionar la Base de Datos: '.mysql_error());
		}

		public function desconectar() {
			try {
				if ($this->link){
					mysql_close($this->link);
					$this->link = NULL;
				}
			}
			catch (Exception $exc) {
				echo $exc->getTraceAsString();
			}
		}

		public function _getLink(){
			return $this->link;
		}

		public function __destruct() {
			try {
				if ($this->link) $this->desconectar();
			}
			catch (Exception $exc) {
				echo $exc->getTraceAsString();
			}
		}
	}
?>
