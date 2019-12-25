<?php
// file that will accept product ID to read a record from the database.
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$product = new Product($db);

// read id
$id = $_GET['id'];

// validate product id
if (isset($id) && !empty($id)) {
  if (is_numeric($id)) {
    $product->id = $id;

    echo json_encode(array("200 - Success ID"));

    if ($product->read_one()) {
      $product_item = array(
        "id" => $product->id,
        "name" => $product->name,
        "description" => $product->description,
        "price" => $product->price,
        "category_id" => $product->category_id,
        "category_name" => $product->category_name,
        "created" => $product->created
      );

      http_response_code(200);

      echo json_encode($product_item);
    }
  }
  else {
    http_response_code(412);

    echo json_encode(array("412 - Precondition failed"));
  }
}
else {
  http_response_code(400);

  echo json_encode(array("400 - Bad Request"));
}


