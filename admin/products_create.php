<?php
// to show the errors that might happen, including where in this program, 
// meaning - which lines in this program we have the error 

use Verot\Upload\Upload;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/../config.php";

$pageTitle = "Create Product";

include "header.php";
?>

<main class="bg-light">
  <div class="jumbotron">
    <div class="container">
      <h1 class="py-5">Create Product</h1>
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
        // check and upload photo first
        // include uploader class
        include SITE_ROOT . "/libs/class.upload.php";

        if ($_FILES['photo']['error'] == 0) {
          $handle = new Upload($_FILES["photo"]);

          if ($handle->uploaded) {
            $handle->allowed = array('image/*');
            $handle->Process('./uploads/');

            if ($handle->processed) {
              $photo  = $handle->file_dst_name; // set $photo with file name
            } else {
              echo '<div class="alert alert-dismissable fade show alert-info">' . $handle->error . '<button type="button" class="close border-0 bg-transparent text-dark float-end" data-bs-dismiss="alert" aria-label="Close">x</button></div>';
              $photo = 'no_image.png'; // set $photo to no_image.png
            }
            $handle->Clean();
          } else {
            echo '<div class="alert alert-dismissable fade show alert-info"> ' . $handle->error . '<button type="button" class="close border-0 bg-transparent text-dark float-end" data-bs-dismiss="alert" aria-label="Close">x</button></div>';
            $photo = 'no_image.png'; // set $photo to no_image.png
          }
        } else {
          echo '<div class="alert alert-dismissable fade show alert-warning">Photo not selected!<button type="button" class="close border-0 bg-transparent text-dark float-end" data-bs-dismiss="alert" aria-label="Close">x</button></div>';
          $photo = 'no_image.png'; // set $photo to no_image.png
        }

        // then insert data to database 

        // include database connection
        include '../config/db.php';

        try {

          // insert query
          $query = "INSERT INTO products SET title=:title, description=:description, price=:price, photo=:photo, created=:created";

          // prepare query for execution
          $stmt = $conn->prepare($query);

          // posted values
          $title = htmlspecialchars(strip_tags($_POST['title']));
          $description = htmlspecialchars(strip_tags($_POST['description']));
          $price = htmlspecialchars(strip_tags($_POST['price']));

          // bind the parameters
          $stmt->bindValue(':title', $title);
          $stmt->bindValue(':description', $description);
          $stmt->bindValue(':price', $price, PDO::PARAM_INT);
          $stmt->bindValue(':photo', $photo);

          // specify when this record was inserted to the database
          $created = date('Y-m-d H:i:s');
          $stmt->bindValue(':created', $created);

          // Execute the query
          if ($stmt->execute()) {
            echo '<div class="alert alert-dismissable fade show alert-success">Record was saved.<button type="button" class="close border-0 bg-transparent text-dark float-end" data-bs-dismiss="alert" aria-label="Close">x</button></div>';
          } else {
            echo '<div class="alert alert-dismissable fade show alert-danger">Unable to save record.<button type="button" class="close border-0 bg-transparent text-dark float-end" data-bs-dismiss="alert" aria-label="Close">x</button></div>';
          }
        }

        // show error
        catch (PDOException $exception) {
          die('ERROR: ' . $exception->getMessage());
        }
      }
    } else {
      // At least one input field is empty, handle the error (e.g., display a message to the user)
      echo '<div class="alert alert-dismissable fade show alert-warning">Please fill out all the fields in the form.<button type="button" class="close border-0 bg-transparent text-dark float-end" data-bs-dismiss="alert" aria-label="Close">x</button></div>';
    }
    ?>


    <a href="products_read.php" class="btn btn-secondary float-end mb-3">Back to read products</a>

    <form action="products_create.php" method="post" enctype="multipart/form-data">
      <table class="table table-hover table-bordered">
        <tr>
          <td>Title</td>
          <td><input type="text" name="title" class="form-control" /></td>
        </tr>
        <tr>
          <td>Description</td>
          <td><textarea name="description" class="form-control"></textarea></td>
        </tr>
        <tr>
          <td>Price</td>
          <td><input type="text" name="price" class="form-control" /></td>
        </tr>
        <tr>
          <td>Photo</td>
          <td><input type="file" name="photo" /></td>
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
include "footer.php";
?>