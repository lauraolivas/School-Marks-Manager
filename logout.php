<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>School Marks Manager - Login</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

    
  </head>

  <body class="bg-dark">
    <?php
    session_start();
    $_SESSION = [];
    session_destroy();
    echo '<div class="container" id="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header text-danger">Logout correctly!</div>
      <div class="card-body">
        <div class="text-center">
          <a href="login.php" class="d-block small mt-3">Back to login</a>
        </div>
      </div>
    </div>
  </div>';
    ?>
</body>
</html>