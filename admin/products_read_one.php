<?php
// to show the errors that might happen, including where in this program, 
// meaning - which lines in this program we have the error 
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($_GET['id'])) {
  // include database connection
  include '../config/db.php';

  // read current record's data
  try {
    // prepare select query
    $query = "SELECT title, description, price, photo FROM products WHERE id = :id LIMIT 0,1";
    $stmt = $conn->prepare($query);

    // posted values
    $id = htmlspecialchars(strip_tags($_GET['id']));

    // bind the parameters
    $stmt->bindValue(':id', $id);

    // execute our query
    $stmt->execute();

    // store retrieved row to a variable
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // values to fill up our table
    $title = $row['title'];
    $description = $row['description'];
    $price = $row['price'];
    $photo = $row['photo'];
  }

  // show error
  catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
  }
} else {
  die("ERROR: ID not set.");
}

$pageTitle = "Read " . $title;
include("header.php");
?>


<main class="bg-light">
  <div class="jumbotron">
    <div class="container">
      <h1 class="py-5"><?php echo $pageTitle ?> Page</h1>
    </div>
  </div>
  <div class="container py-5">
    <a href="products_read.php" class="btn btn-secondary float-end mb-2">Back to read products</a>
    <table class="table table-hover table-bordered">
      <tr>
        <td>ID</td>
        <td><?php echo $id; ?></td>
      </tr>
      <tr>
        <td>Title</td>
        <td><?php echo $title; ?></td>
      </tr>
      <tr>
        <td>Description</td>
        <td><?php echo nl2br($description); ?></td>
      </tr>
      <tr>
        <td>Price</td>
        <td><?php echo $price; ?></td>
      </tr>
      <tr>
        <td>Photo</td>
        <td><img src="./uploads/<?php echo $photo; ?>" width="30%"></td>
      </tr>
    </table>
  </div>
</main>


<?php
include("footer.php");
?>