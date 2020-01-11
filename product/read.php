<?php
// file that will output JSON data based from "products" database records.

// required headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset-UTF-8');
header("Access-Control-Allow-Methods: GET");

// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';

// instantiate database object
$database = new Database();
$db= $database->getConnection();

// initialize product object
$product = new Product($db);

// query products
$stmt = $product->read();
$num = $stmt->rowCount();

// check if more that 0 record found
if ($num > 0) {

  // Create product records array
  $products = array();
  $products["count"] = $num;
  $products['records'] = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    // extract row this will make $row['name'] to just $name only
    extract($row);

    /** @var TYPE_NAME $id */
    /** @var TYPE_NAME $name */
    /** @var TYPE_NAME $description */
    /** @var TYPE_NAME $price */
    /** @var TYPE_NAME $category_id */
    /** @var TYPE_NAME $category_name */
    /** @var TYPE_NAME $created */

    $product_item = array(
      "id" => $id,
      "name" => $name,
      "description" => html_entity_decode($description),
      "price" => $price,
      "category_id" => $category_id,
      "category_name" => $category_name,
      "created" => $created
    );

    array_push($products["records"], $product_item);
  }

  http_response_code(200);

  echo json_encode($products);
}
 else {
   // Set response code - 404 Not Found
   http_response_code(404);
   echo json_encode(array('message' => "No products founnd."));
 }