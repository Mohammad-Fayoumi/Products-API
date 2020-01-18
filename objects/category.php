<?php
// contains properties and methods for "category" database queries.

class Category {

  private $conn;
  private $table_name = 'categories';

  // object properties
  public $name;
  public $description;
  public $created;

  public function __construct($db) {
    $this->conn = $db;
  }
  
  // select all data
  public function read() {
    try {
      $query = "SELECT id, name, description, created FROM {$this->table_name} ORDER BY name";
      
      // Prepare to execute the query
      $stmt = $this->conn->prepare($query);

      // Execute the query
      $stmt->execute(); 
    }
    catch(PDOException $exception){
      $exception->getMessage();
    }

    return $stmt;
  }
}