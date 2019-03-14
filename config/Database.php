<?php 

class Database
{
	//Data Base Credentials:
	private $host = 'localhost';
	private $dbName = 'api_db';
	private $user = 'root';
	private $password = '030599';
	public $conn;

	public function getConnection()
	{
		$this->conn = null;

		try {
			
			$this->conn = new PDO('mysql:host='. $this->host. ';dbname='. $this->dbName , $this->user, $this->password);
			$this->conn->exec("set names utf8");

		} catch (PDOException $e) {
			echo "Connection Error: ". $e->getMessage();
		}

		return $this->conn;
	}
}


 ?>