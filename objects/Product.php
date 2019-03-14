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
}


?>