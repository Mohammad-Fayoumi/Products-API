<?php
// file that will output JSON data based from "categories" database records.
// required headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset-UTF-8');
header("Access-Control-Allow-Methods: GET");

include_once "../config/database.php";
include_once "../objects/category.php";

// prepare database connection object
$database = new Database();
$db = $database->getConnection();

// prepare category object
$catergory = new Category($db);

// get records
$stmt = $catergory->read();
$num = $stmt->rowCount();

// check for number of rows
if ($num > 0) {

  //create products record array
  $categories = array();
  $categories['records'] = array();

  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    // extract row this will make $row['name'] to just $name only
    extract($row);

    /** @var TYPE_NAME $name */
    /** @var TYPE_NAME $description */
    /** @var TYPE_NAME $created */
    $category_item = array(
      "id" => $id,
      "name" => $name,
      "description" => html_entity_decode($description),
      "created" => $created
    );

    array_push($categories['records'], $category_item);
  }

  // set response code - 200 OK
  http_response_code(200);

  // show products data
  echo json_encode($categories);
}
else {
  // Set response code - 404 Not Found
  http_response_code(404);
  echo json_encode(array('message' => "No Categories founnd."));
}
