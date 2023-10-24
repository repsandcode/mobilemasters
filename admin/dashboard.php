<?php
$pageTitle = "MobileMasters";
include("header.php");
?>

<main class="bg-light">
  <div class="jumbotron">
    <div class="container">
      <h1 class="py-5">Dashboard</h1>
    </div>
  </div>
  <div class="container py-3">
    <h3>Welcome to Admin Panel</h3>
    <p>Here you can manage your online shop. To start, select from the top menu.</p>

    <div class="row">
      <?php echo $out; ?>
    </div>
  </div>
</main>

<?php
include("footer.php");
?>