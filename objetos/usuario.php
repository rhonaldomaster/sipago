<?php

	class Usuario{
		
		private $id=0;
		private $nombres="";
		private $apellidos="";
		private $identificacion="";
		private $idTipoIdentificacion=1;
		private $tipoIdentificacion="";
		private $direccion="";
		private $telefono="";
		
		public function __construct() {
			
		}
		
		public function getNombres(){
			return $this->nombres;
		}
		
		public function getApellidos(){
			return $this->apellidos;
		}
		
		public function setId($idn){
			$this->id = $idn;
		}
		
		public function setNombres($nombresn){
			$this->nombres = $nombresn;
		}
		
		public function setApellidos($apellidosn){
			$this->apellidos = $apellidosn;
		}
	}
?>
