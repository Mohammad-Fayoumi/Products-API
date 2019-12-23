<?php
// contains properties and methods for "product" database queries.

class Product
{
  private $conn;
  private $table_name = 'products';

  // object properties
  public $id;
  public $name;
  public $description;
  public $price;
  public $category_id;
  public $category_name;
  public $created;

  // constructor with $db as database connection
  public function __construct($db) {
    $this->conn = $db;
  }

  function sanitize($var) {
    return htmlspecialchars(strip_tags($var));
  }

  // read products
  function read() {
    try {
      // Select all products
      $query = "SELECT c.name, p.id, p.name, p.description, p.price, p.category_id, p.created
       FROM " . $this->table_name . " p 
       LEFT JOIN 
       categories c 
       ON p.category_id = c.id
       ORDER BY p.created DESC";

      // Prepare to execute the query
      $stmt = $this->conn->prepare($query);

      // Execute the query
      $stmt->execute();
    }
    catch (PDOException $exception) {
      $exception->getMessage();
    }
    return $stmt;
  }

  // Create product
  function create() {
    $query = "INSERT INTO ". $this->table_name ." SET name=:name, price=:price, description=:description, category_id=:category_id, created=:created";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // bind and sanitize values
    $stmt->bindParam(":name", $this->sanitize($this->name));
    $stmt->bindParam(":price", $this->sanitize($this->price));
    $stmt->bindParam(":description", $this->sanitize($this->description));
    $stmt->bindParam(":category_id", $this->sanitize($this->category_id));
    $stmt->bindParam(":created", $this->sanitize($this->created));

    // execute query
    if ($stmt->execute()) {
      return true;
    }

    return false;
  }
}
