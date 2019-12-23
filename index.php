<?php
include_once "config/database.php";
include_once "objects/product.php";

$db_conn = new Database();
$product = new Product($db_conn->getConnection());

$product_read = $product->read();
//var_dump($product_read->fetchAll());
//
while ($row = $product_read->fetch(PDO::FETCH_ASSOC)) {
  // extract row
  // this will make $row['name'] to
  // just $name only

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
}