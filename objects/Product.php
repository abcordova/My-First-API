<?php 

class Product
{
	private $conn;
	private $table_name = 'products';

	public $id;
	public $name;
	public $description;
	public $price;
	public $category_id;
	public $category_name;
	public $created;

	function __construct($db)
	{
		$this->conn = $db;
	}

	//Will return products:
	function read()
	{
		$sql = sprintf(

			"SELECT 
				c.name as category_name, 
				p.id,
				p.name,
				p.description,
				p.price,
				p.category_id,
				p.created
			FROM
				%s p
			LEFT JOIN
				categories c
				ON p.category_id = c.id
			ORDER BY
				p.created DESC", 

			$this->table_name
		);

		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		return $stmt;

	}

	public function create()
	{			
		/*
			Don`t forgget the steps
			first create the query then
			prepare the query adding to a stmt variable after
			sanitize the parameters then
			bind the parameters 
			e finally execute the query
		*/

		$sql = sprintf(

			"INSERT INTO 
				%s
			SET
				name = :name,
				price = :price,
				description = :description,
				category_id = :category_id,
				created = :created",

			$this->table_name
		);

		$stmt = $this->conn->prepare($sql);

		/*
			This following block is responsable to
			secure the input data.
		*/
		$this->name 	   = htmlspecialchars(strip_tags($this->name));
		$this->price 	   = htmlspecialchars(strip_tags($this->price));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->category_id = htmlspecialchars(strip_tags($this->category_id));
		$this->created     = htmlspecialchars(strip_tags($this->created));

		$stmt->bindParam(":name", $this->name);
		$stmt->bindParam(":price", $this->price);
		$stmt->bindParam(":description", $this->description);
		$stmt->bindParam(":category_id", $this->category_id);
		$stmt->bindParam(":created", $this->created);

		if($stmt->execute()){
			return true;

		} else {
			return false;
		}
	}
}

?>