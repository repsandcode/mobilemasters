<?php
// check for GET
if (isset($_GET['id'])) {

  // include database connection
  include './config/db.php';

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

    // add data to $out
    $out =
      '<div class="row shadow bg-body-tertiary rounded border-0 py-0 p-md-4">
      <div class="px-0 px-md-3 col-md-6 col-lg-7 d-flex justify-content-center"> 
        <img class="card-image-top object-fit-cover overflow-hidden" src="admin/uploads/' . $row['photo'] . '" style="height: 280px;" alt="">
      </div>  
      <div class="px-3 col-md-6 col-lg-5">
        <div class="card-body py-4 pt-md-0">
          <h3 class="card-title mb-3">' . $row['title'] . '</h3>
          <p class="card-text fs-6">' . $row['description'] . '</p>
        </div>
        <div class="card-footer pb-3 pb-md-0"><strong class="fs-4">$' . $row['price'] . '</strong></div>
      </div>
    </div>';
  }

  // show error
  catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
  }
} else {
  die("ERROR: ID not set.");
}

$pageTitle = $row['title'];

include("header.php")
?>

<div class="container-lg px-4 py-5">
  <?php
  // out
  echo $out;
  ?>
</div>

<?php include("footer.php") ?>