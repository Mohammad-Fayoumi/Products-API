<?php
// file that will accept a product ID to delete a database record.
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");

// Maximum number of seconds the results can be cached by second - Here 1 hour.
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";
include_once "../objects/product.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$product = new Product($db);

// get product id
$data = json_decode(file_get_contents("php://input"));

// set ID property of product to be deleted
if (isset($data->id) && !empty($data->id) && is_numeric($data->id)) {
  $product->id = (int)$data->id;

  // delete the product
  if ($product->delete()) {

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Product was deleted."));
  }

  // if unable to delete the product, tell the user
  else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to delete product."));
  }
}

// if the user didn't provide the product's - id - to delete
else {
  http_response_code(412);
  echo json_encode(array("message" => "id - not valid"));
}


