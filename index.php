<?php
// include database connection
include './config/db.php';

$out = '';
// select all data
$query = "SELECT id, title, price, photo FROM products ORDER BY id";
$stmt = $conn->prepare($query);
$stmt->execute();

// this is how to get number of rows returned
$num = $stmt->rowCount();

//check if more than 0 record found
if ($num > 0) {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // creating new table row per record
    $out .=
      '<div class="col-md-6 col-lg-4 col-xl-3">'
      . '<div class="card shadow-sm bg-body-tertiary rounded border-0">'
      . '<img class="card-image-top object-fit-contain" src="admin/uploads/' . $row['photo'] . '" style="height: 280px;" alt="">'
      . '<div class="card-body">'
      . '<h5 class="card-title">' . $row['title'] . '</h5>'
      . '<p class="card-text">$' . $row['price'] . '</p>'
      . '<a href="details.php?id=' . $row['id'] . '"class="btn btn-primary">View more</a>'
      . '</div>'
      . '</div>'
      . '</div>';
  }

  // end products

} else { // if no records found
  $out = '<div class="alert alert-danger">No records found.</div>';
}

$pageTitle = 'Home';

include("header.php")
?>

<div class="container-lg">
  <!-- Catchy Heading -->
  <div class="py-5 text-center">
    <h1 class="fw-normal"> <span class="text-black-50 fw-light"> Welcome to </span> MobileMasters</h1>
    <p> Buy new cell phones at a cheap price!</p>
  </div>


  <!-- Display Products -->
  <main class="row g-4 py-4">

    <?php
    echo $out;
    ?>
  </main>
</div>

<?php include("footer.php") ?>