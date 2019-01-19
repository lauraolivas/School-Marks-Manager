<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>School Marks Manager - Delete student</title>

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
    if(!empty($_SESSION['user'])&&($_SESSION['type']=="teacher"||$_SESSION['type']=='root')){
      
      if (isset($_GET['user'])) {
        $user = $_GET['user'];
      } elseif (isset($_POST['user'])){
        $user = $_POST['user'];
      } else{
        $error= '<p>This page has been accessed in error.</p>';
        exit();
      }
      
      if ($_SERVER['REQUEST_METHOD']=='POST'){
        if(!empty($_POST['inputPassword'])&&empty($_POST['confirmPassword'])){
          $error='<p>Fill the confirm password</p>';
        }elseif($_POST['inputPassword']!==$_POST['confirmPassword']){
          $error='<p>Fill the confirm password correctly</p>';
        }else{
          require ('./mysqli_connect.php');

		      // Make the query:
		      $q = "DELETE FROM users WHERE user=$user LIMIT 1";		
	      	$r = @mysqli_query ($dbc, $q);
          
          if (mysqli_affected_rows($dbc) == 1) {
			      $delete= '<p>The user has been deleted.</p>';
		      } else {
			      $error= '<p>The user could not be deleted due to a system error.</p>'; 
		      }

        mysqli_close($dbc);
        }
      }
    
	?>
    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Delete student</div>
        <div class="card-body">
          <?php
          if(!empty($error)){
            echo $error;
          }elseif(!empty($delete)){
            echo $delete;
          }
          ?>
          <form action="" method="post">
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="inputPassword" name="pass1" class="form-control" placeholder="User" required="required" autofocus="autofocus">
                <label for="inputPassword">Password</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="confirmPassword" name="pass2" class="form-control" placeholder="Confirm password" required="required">
                <label for="confirmPassword">Confirm password</label>
              </div>
            </div>
            <input type="submit" class="btn btn-primary btn-block btn-danger" value="Delete">
          </form>
          <div class="text-center">
            <a class="d-block small" href="modifier_delete_student.php">Back to class list</a>
          </div>
        </div>
      </div>
    </div>
    <?php
      }else{
        echo '<div class="container" id="container">
                <div class="card card-register mx-auto mt-5">
                  <div class="card-header text-danger">ERROR</div>
                  <div class="card-body">
                    <div class="text-center">
                      <p>You are not a teacher</p>
                      <a href="login.php" class="d-block small mt-3">Back to login</a>
                    </div>
                  </div>
                </div>
              </div>';
      }
    ?>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    
  </body>
  
</html>
