<?php
// file that will accept a product ID to update a database record.
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

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
$data = json_decode(file_get_contents("php://input"));

// set ID property of product to be edited
if (isset($data->id) && !empty($data->id) && is_numeric($data->id)) {
  $data->id = (int)$data->id;

  // Check if the created field value is less than the current time
  if (isset($data->created) && !empty($data->created)) {
    if (strtotime($data->created) < time())
      $data->created = strtotime($data->created);
    else {
      http_response_code(412);
      echo json_encode(array("message" => "created - not valid"));
    }
  }

  // update the product
  if ($product->update($data)) {

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Product was updated."));
  }

  // if unable to update the product, tell the user
  else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to update product."));
  }
}

// if the user didn't provide the product's - id - to update
else {
  http_response_code(412);
  echo json_encode(array("message" => "id - not valid"));
}

