<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Acccess-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Resquested-With");

include_once '../config/Database.php';
include_once '../objects/Product.php';


//Gets the connection to the Database:
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

//get Posted data:
$data = json_decode(file_get_contents("php://input"));

//To make sure that the data is not empty
if (
	!empty($data->name) &&
	!empty($data->price) &&
	!empty($data->description) &&
	!empty($data->category_id)
) {
	
	//Will set the product property values
	$product->name = $data->name;
	$product->price = $data->price;
	$product->description = $data->description;
	$product->category_id = $data->category_id;
	$product->created = date('Y-m-d H:i:s');

	//Create the product 
	if($product->create()){

		//Set Response code 201 to create:
		http_response_code(201);

		//Tell the user the success:
		echo json_encode(array("message" => "Product was created."));
	}else{

		//Set the response to 503 - Service unavailable
		http_response_code(503);

		//Tell the user the fail
		echo json_encode(array("message" => "Unable to create product."));

	}
} else {

	//Set the response to bad response
	http_response_code(404);

	//The the user that the product is incomplet:
	json_encode(array("message" => "Unable to create product. data is incomplete"));
}

?>