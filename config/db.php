<?php
// used to connect to the database
$host = "localhost";
$db_name = "mobile_masters";
$username = "root";
$password = "root";

try {
  $conn = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
}

// show error
catch (PDOException $exception) {
  echo "Connection error: " . $exception->getMessage();
}
