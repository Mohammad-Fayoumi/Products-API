<?php
// file that will output "products" JSON data with pagination.
// required headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset-UTF-8');
header("Access-Control-Allow-Methods: GET");

// include database, core, utilities and object files
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../config/core.php';
include_once '../shared/utilities.php';

// instantiate database object
$database = new Database();
$db = $database->getConnection();

// initialize product object
$product = new Product($db);

// get current page records
$stmt = $product->read_paging($core['start_from'], $records_per_page);
$num = $stmt->rowCount();

// check for number of rows
if ($num > 0) {

  //create products record array
  $products = array();
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

  $pager = new Utilities();

  // include paging
  $total_rows = $product->count();
  $products['total_rows'] = $total_rows;
  $page_url = "{$core['url']}product/read_paging.php?";
  $products['pages'] = $pager->getPaging($core['page'], $total_rows, $records_per_page, $page_url);

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