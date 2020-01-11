<?php
// file that will accept keywords parameter to search "products" database.
// required headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset-UTF-8');
header("Access-Control-Allow-Methods: GET");
echo json_encode(array("message" => "To search in products use ?keyword=data in the url and this keyword will be applicable only on product name, product description and category name"));

// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';

// instantiate database object
$database = new Database();
$db = $database->getConnection();

// initialize product object
$product = new Product($db);

//check if keyword is set and not empty
if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
  $keyword =  $_GET['keyword'];
}
else {
  // Set response code - 412 Invalid data
  http_response_code(412);
  die(json_encode(array('message' => "Invalid keyword.")));
}

// query products
$stmt = $product->search($keyword);
$num = $stmt->rowCount();

// check for number of rows
if ($num > 0) {

  //create products record array
  $products = array();
  $products['count'] = $num;
  $products['records'] = array();

  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    // extract row this will make $row['name'] to just $name only
    extract($row);

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

    array_push($products['records'], $product_item);
  }

  // set response code - 200 OK
  http_response_code(200);

  // show products data
  echo json_encode($products);
}
else {
  // Set response code - 404 Not Found
  http_response_code(404);
  echo json_encode(array('message' => "No products founnd."));
}
