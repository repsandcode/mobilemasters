<?php
// to show the errors that might happen, including where in this program, 
// meaning - which lines in this program we have the error 

use Verot\Upload\Upload;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/../config.php";


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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Assume $_POST is the array containing form data submitted via POST method
  $isFormValid = true;

  if ($isFormValid) {
    // check and upload photo first if new photo selected
    // include uploader class
    echo "inside valid form";
    include SITE_ROOT . "/libs/class.upload.php";

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
      $handle = new Upload($_FILES["photo"]);

      if ($handle->uploaded) {
        $handle->allowed = array('image/*');
        $handle->Process('./uploads/');

        if ($handle->processed) {
          $photo  = $handle->file_dst_name; // set $photo with file name
        } else {
          $error = '<div class="alert alert-info">' . $handle->error . '</div>';
          $photo = $photo; // set $photo to the current photo
        }
        $handle->Clean();
      } else {
        $error = '<div class="alert alert-info">' . $handle->error . '</div>';
        $photo = $photo; // set $photo to the current photo
      }
    } else {
      // this means photo field not selected, so we use current photo
      $photo = $photo; // set $photo to the current photo, It's not necessary actually! just to see what's happened
    }

    try {
      // insert query
      $query = "UPDATE products SET title=:title, description=:description, price=:price, photo=:photo WHERE id = :id";

      // prepare query for execution
      $stmt = $conn->prepare($query);

      // posted values
      $title = htmlspecialchars(strip_tags($_POST['title']));
      $description = htmlspecialchars(strip_tags($_POST['description']));
      $price = htmlspecialchars(strip_tags($_POST['price']));
      // $photo defined before

      // bind the parameters
      $stmt->bindValue(':title', $title);
      $stmt->bindValue(':description', $description);
      $stmt->bindValue(':price', $price);
      $stmt->bindValue(':photo', $photo);
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
}

$pageTitle = "Update " . $title;
include("header.php");
?>


<main class="bg-light">
  <div class="jumbotron">
    <div class="container">
      <h1 class="py-5">Update <?php echo $title ?></h1>
    </div>
  </div>
  <div class="container py-5">
    <!-- ERROR alert -->
    <?php echo $error ?? ""; ?>
    <!-- STATUS ALERT -->
    <?php echo $status_alert ?? ""; ?>
    <a href="products_read.php" class="btn btn-secondary float-end mb-2">Back to read products</a>
    <!-- html form here where the product information will be entered -->
    <form action="products_update.php?id=<?php echo $id; ?>" method="post">
      <table class="table table-hover table-bordered">
        <tr>
          <td>Title</td>
          <td><input type="text" name="title" class="form-control" value="<?php echo $title; ?>" /></td>
        </tr>
        <tr>
          <td>Description</td>
          <td><textarea name="description" class="form-control"><?php echo $description; ?></textarea></td>
        </tr>
        <tr>
          <td>Price</td>
          <td><input type="text" name="price" class="form-control" value="<?php echo $price; ?>" /></td>
        </tr>
        <tr>
          <td>New Photo</td>
          <td><input type="file" name="photo" /></td>
        </tr>
        <tr>
          <td>Current Photo</td>
          <td><img src="./uploads/<?php echo $photo; ?>" width="30%"></td>
        </tr>
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