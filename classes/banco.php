<?php


class banco extends PDO {
	
		private $conn;	
		// Função "mágica" para conectar com o banco
		private $user = "root";
		private $pass ="";
		private $name = "mysql:host=localhost;dbname=hotel";
 
	public function __construct()
		{
		parent::__construct($this->name, $this->user, $this->pass,array(
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ));
		 
		}
				
		
}


?>