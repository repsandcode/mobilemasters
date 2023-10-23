<?php
// Include database connection
include 'config/db.php';

// Creating Pages Table
try {

  // insert query
  $query_for_table_pages = "CREATE table `pages`(
		`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`title` varchar(100),
		`body` TEXT
		)";
  // prepare query for execution
  $stmt = $conn->prepare($query_for_table_pages);
  // Execute the query
  if ($stmt->execute()) {
    echo "<p>Table pages created!</p>";
  } else {
    echo "<p>Error in creating pages table</p>";
  }
}

// show error
catch (PDOException $exception) {
  die('ERROR: ' . $exception->getMessage());
}

// Creating Products Table
try {

  // insert query
  $query_for_table_products = "CREATE table `products`(
		`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`title` varchar(100),
		`description` TEXT,
		`price` int(10),
		`photo` varchar(1000),
		`created` datetime NOT NULL,
		`modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)";
  // prepare query for execution
  $stmt = $conn->prepare($query_for_table_products);
  // Execute the query
  if ($stmt->execute()) {
    echo "<p>Table products created!</p>";
  } else {
    echo "<p>Error in creating product table</p>";
  }
}

// show error
catch (PDOException $exception) {
  die('ERROR: ' . $exception->getMessage());
}
