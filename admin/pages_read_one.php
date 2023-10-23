<?php
// to show the errors that might happen, including where in this program, 
// meaning - which lines in this program we have the error 
error_reporting(E_ALL);
ini_set('display_errors', 1);

// isset() is a PHP function used to verify if a value is there or not
if (isset($_GET['id'])) {
  // include database connection
  include '../config/db.php';

  // read current record's data
  try {
    // prepare select query
    $query = "SELECT title, body FROM pages WHERE id = :id LIMIT 0,1";
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
    $body = $row['body'];
    $pageTitle = 'Read ' . $title;
  }
  // show error
  catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
  }
} else {
  die("ERROR: ID not set.");
}

include("header.php");
?>


<main class="bg-light">
  <div class="jumbotron">
    <div class="container">
      <h1 class="py-5">Read <?php echo $title; ?></h1>
    </div>
  </div>
  <div class="container py-5">
    <a href="pages_read.php" class="btn btn-secondary float-end mb-2">Back to read pages</a>
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
        <td>Body</td>
        <td><?php echo nl2br($body); ?></td>
      </tr>
    </table>
  </div>
</main>

<?php
include("footer.php");
?>