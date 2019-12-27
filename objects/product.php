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
      $query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
       FROM " . $this->table_name . " p 
       LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created DESC";

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

  // read products
  function read_one() {
    try {
      // Select all products
      $query = "SELECT c.name AS category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
       FROM " . $this->table_name . " p 
       LEFT JOIN 
       categories c 
       ON p.category_id = c.id
       where p.id = ?
       LIMIT 0,1";

      // Prepare to execute the query
      $stmt = $this->conn->prepare($query);

      // bind id of product to be updated
      $stmt->bindParam(1, $this->id);

      // Execute the query
      $stmt->execute();

      // get retrieved row
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set values to object properties
      $this->id = $row['id'];
      $this->name = $row['name'];
      $this->price = $row['price'];
      $this->description = html_entity_decode($row['description']);
      $this->category_id = $row['category_id'];
      $this->category_name = $row['category_name'];
      $this->created = $row['created'];

      return true;
    }
    catch (PDOException $exception) {
      $exception->getMessage();
    }

    return false;
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
