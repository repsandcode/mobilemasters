<?php
// to show the errors that might happen, including where in this program, 
// meaning - which lines in this program we have the error 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/../config.php";

$pageTitle = "Create Page";

include "header.php";
?>


<main class="bg-light">

  <div class="jumbotron">
    <div class="container">
      <h1 class="py-5">Create Pages</h1>
    </div>
  </div>

  <div class="container py-4">

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Assume $_POST is the array containing form data submitted via POST method
      $isFormValid = true;

      foreach ($_POST as $key => $value) {
        // Check if the input field is empty
        if (empty($value)) {
          $isFormValid = false;
          // Optionally, you can break the loop if you only need to check if any input is empty
          break;
        }
      }

      if ($isFormValid) {
        // include database connection
        include '../config/db.php';

        try {
          // insert query
          $query = "INSERT INTO pages SET title=:title, body=:body";

          // prepare query for execution
          $stmt = $conn->prepare($query);
          // posted values
          $title = htmlspecialchars(strip_tags($_POST['title']));
          $body = htmlspecialchars(strip_tags($_POST['body']));

          // bind the parameters
          $stmt->bindValue(':title', $title);
          $stmt->bindValue(':body', $body);

          // Execute the query
          if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Record was saved.</div>";
          } else {
            echo "<div class='alert alert-danger'>Unable to save record.</div>";
          }
        } catch (PDOException $exception) {
          die('ERROR: ' . $exception->getMessage());
        }
      }
    }

    ?>

    <a href="pages_read.php" class="btn btn-secondary float-end mb-3">Back to read pages</a>

    <form action="pages_create.php" method="post">
      <table class="table table-hover table-bordered">
        <tr>
          <td>Title</td>
          <td><input type="text" name="title" class="form-control" /></td>
        </tr>
        <tr>
          <td>Body</td>
          <td><textarea name="body" class="form-control"></textarea></td>
        </tr>
        <tr>
          <td></td>
          <td>
            <input type="submit" value="Create" class="btn btn-primary" />
          </td>
        </tr>
      </table>
    </form>
  </div>

</main>

<?php
include("footer.php");
?>