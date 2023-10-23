<?php
// check for GET
if (isset($_GET['id'])) {
  // include database connection
  include './config/db.php';

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

    // add data to $out
    $out =
      '<div class="row shadow bg-body-tertiary rounded border-0 py-0 p-md-4">
      <div class="px-3">
        <div class="card-body py-4 pt-md-0">
          <h3 class="card-title mb-3">' . $row['title'] . '</h3>
          <p class="card-text fs-6">' . nl2br($row['body']) . '</p>
        </div>
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