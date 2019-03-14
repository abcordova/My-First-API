<?php 

//Required Headers
//allow anyone to read this file
header("Access-Control-Allow-Origin: *");
//define which type of contente it will return, in this case will be a json
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../objects/Product.php';

//Get the connection:
$database = new Database();
$db = $database->getConnection();
//Pass the connection for the product class:
$product = new Product($db);


// query products:
$stmt = $product->read();


//Will check if more than 0 record were found

if (!$stmt == null) {
	
	// products Array:
	$product_arr = array();
	$product_arr['records'] = array();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		
		//It will make $row['name'] to $name
		extract($row);

		$product_item = array(
			"id" => $id,
			"name" => $name,
			"description" => $description,
			"price" => $price,
			"category_id" => $category_id,
			"category_name" => $category_name
		);

		array_push($product_arr['records'], $product_item);

	}

	//Set the response in case of success:
	http_response_code(200);

	$results  = json_encode($product_arr);
	echo $results;
} else {
	//set response to not foun
	http_response_code(404);

	$response = array("message" => "No products found"); 
	$response = json_encode($response);

	echo $response;

}

?>