<?php
// to show the errors that might happen, including where in this program, 
// meaning - which lines in this program we have the error 
error_reporting(E_ALL);
ini_set('display_errors', 1);


$pageTitle = "Read Products";
include("header.php");
?>


<main class="bg-light">
  <div class="jumbotron">
    <div class="container">
      <h1 class="py-5">All Products</h1>
    </div>
  </div>
  <div class="container py-5">

    <?php
    // include database connection
    include '../config/db.php';

    // DELETE A RECORD
    if (isset($_GET['delete'])) {
      try {
        // delete query
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $conn->prepare($query);

        // posted values
        $delete = htmlspecialchars(strip_tags($_GET['delete']));

        // bind the parameters
        $stmt->bindValue(':id', $delete);

        if ($stmt->execute()) {
          // redirect to read all products and 
          // tell the user that it was was deleted
          header('Location: products_read.php?message=deleted');
        } else {
          echo "<div class='alert alert-danger'>Unable to delete product.</div>";
        }
      }
      // show error
      catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
      }
    }
    if (isset($_GET['message']) && $_GET['message'] == 'deleted') {
      echo "<div class='alert alert-success'>Product was deleted.</div>";
    }

    // CREATE A NEW PAGE BUTTON
    echo '<a href="products_create.php" class="btn btn-primary float-end mb-2">Create New Product</a>';

    // select all data
    $query = "SELECT id, title, price FROM products ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // this is how to get number of rows returned
    $num = $stmt->rowCount();

    //check if more than 0 record found
    if ($num > 0) {

      // data from database will be here
      echo '<table class="table table-hover table-bordered">'; //start table

      //creating our table heading
      echo '<tr>';
      echo '<th>ID</th>';
      echo '<th>Title</th>';
      echo '<th>PRICE</th>';
      echo '<th>Action</th>';
      echo '</tr>';

      // retrieve our table contents

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // creating new table row per record
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['title'] . '</td>';
        echo '<td>' . $row['price'] . '</td>';
        echo '<td>';
        // read one record 
        echo '<a href="products_read_one.php?id=' . $row['id'] . '" class="btn btn-info btn-sm me-2 mb-1">Read</a>';

        // update one record
        echo '<a href="products_update.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm me-2 mb-1">Edit</a>';

        // delete one record but with confirmation warning
        echo '<a href="#" data-href="products_read.php?delete=' . $row['id'] . '" data-bs-toggle="modal" data-bs-target="#confirm-delete" class="btn btn-danger btn-sm mb-1">Delete</a>';
        echo '</td>';
        echo '</tr>';
      }

      // end table
      echo '</table>';
    } else { // if no records found
      echo '<div class="alert alert-danger">No records found.</div>';
    }
    ?>

  </div>
</main>

<!-- Modal is here-->
<div class="modal fade" id="confirm-delete" aria-labelledby="delete-pages-model">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        Confirm Delete
      </div>
      <div class="modal-body">
        <p>Are you sure?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a class="btn btn-danger btn-ok">Delete</a>
      </div>
    </div>
  </div>
</div>


<?php
include("footer.php");
?>