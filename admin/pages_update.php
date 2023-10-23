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

    // values to fill up our form
    $title = $row['title'];
    $body = $row['body'];
  }

  // show error
  catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
  }
} else {
  die("ERROR: ID not set.");
}

if ($_POST) {
  try {
    // insert query
    $query = "UPDATE pages SET title=:title, body=:body WHERE id = :id";

    // prepare query for execution
    $stmt = $conn->prepare($query);

    // posted values
    $title = htmlspecialchars(strip_tags($_POST['title']));
    $body = htmlspecialchars(strip_tags($_POST['body']));

    // bind the parameters
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':body', $body);
    $stmt->bindValue(':id', $id);

    // Execute the query
    if ($stmt->execute()) {
      $status_alert = "<div class='alert alert-success'>Record was updated.</div>";
    } else {
      $status_alert = "<div class='alert alert-danger'>Unable to updated record.</div>";
    }
  }

  // show error
  catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
  }
}

$pageTitle = "Update " . $title;
include("header.php");
?>


<main class="bg-light">
  <div class="jumbotron">
    <div class="container">
      <h1 class="py-5">Update <?php echo $title ?> Page</h1>
    </div>
  </div>
  <div class="container py-5">
    <!-- STATUS ALERT -->
    <?php echo $status_alert ?? ""; ?>
    <a href="pages_read.php" class="btn btn-secondary float-end mb-2">Back to read pages</a>
    <!-- html form here where the product information will be entered -->
    <form action="pages_update.php?id=<?php echo $id; ?>" method="post">
      <table class="table table-hover table-bordered">
        <tr>
          <td>Title</td>
          <td><input type="text" name="title" class="form-control" value="<?php echo $title; ?>" /></td>
        </tr>
        <tr>
          <td>Body</td>
          <td><textarea name="body" class="form-control" style="height: 200px;"><?php echo $body; ?></textarea></td>
        </tr>
        <tr>
          <td></td>
          <td>
            <input type="submit" value="Edit" class="btn btn-primary" />
          </td>
        </tr>
      </table>
    </form>
  </div>
</main>



<?php
include("footer.php");
?>