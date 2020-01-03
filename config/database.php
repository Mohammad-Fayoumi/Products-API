<?php
// file used for connecting to the database.

class Database
{
  // specify your own database credentials
  private $host = "localhost";
  private $db_name = "api_db";
  private $username = "root";
  private $password = "root";
  public $conn;

  // get the database connection
  public function getConnection()
  {

    $this->conn = null;

    try {

      $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
      ];

      $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password, $options);
      $this->conn->exec("set names utf8");
    } catch (PDOException $exception) {
      echo "Connection error: " . $exception->getMessage();
    }

    return $this->conn;
  }
}
