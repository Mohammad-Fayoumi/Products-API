<?php
// file that will accept posted product data to be saved to database.
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

// Maximum number of seconds the results can be cached by second - Here 1 hour.
//header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once "../config/database.php";
$database = new Database();
$db = $database->getConnection();

// instantiate product object
include_once "../objects/product.php";
$product = new Product($db);

/*
  get posted data
  file_get_contents() function: This function in PHP is used to read a file into a string.
*/
$data = file_get_contents("php://input");

// Convert JSON string into array or object
$data = json_decode($data);

// Make sure data is not empty
if (
  !empty($data->name) &&
  !empty($data->price) &&
  !empty($data->description) &&
  !empty($data->category_id)
) {
  // Set product property values
  $product->name = $data->name;
  $product->price = $data->price;
  $product->description = $data->description;
  $product->category_id = $data->category_id;
  $product->created = date('Y-m-d H:i:s');

  // create the product
  if($product->create()){

    // set response code - 201 created
    http_response_code(201);

    // tell the user
    echo json_encode(array("message" => "Product was created."));
  }

  else {
    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to create product."));
  }
}

// tell the user data is incomplete
else{

  // set response code - 400 bad request
  http_response_code(400);

  // tell the user
  echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}