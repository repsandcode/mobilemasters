<?php
// to show the errors that might happen, including where in this program, 
// meaning - which lines in this program we have the error 
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <title>Login - Admin MobileMasters</title>
</head>

<body>
  <div class="vh-100 vw-100 bg-primary-subtle d-flex justify-content-center align-items-center">
    <div class="container-lg">
      <div class="shadow-lg bg-body rounded mx-auto" style="max-width: 500px;">
        <div class="w-auto p-4">
          <div class="mb-5">
            <h2 class="text-primary fw-normal">Admin - MobileMasters</h2>
          </div>

          <div class="w-100">
            <form action="" method="post">
              <div class="form-group mb-4">
                <label class="fw-medium mb-1" for="username">Username</label>
                <input autofocus class="form-control p-3" type="text" name="username" placeholder="Enter your username" id="username" required>
              </div>
              <div class="form-group mb-4">
                <label class="fw-medium mb-1 dark" for="password">Password</label>
                <input class="form-control p-3" type="password" name="password" placeholder="Enter your password" id="password" required>
              </div>
              <input class="btn btn-primary w-100 py-3" type="submit" value="Sign in">
            </form>
          </div>

        </div>
      </div>

    </div>
  </div>
</body>

</html>