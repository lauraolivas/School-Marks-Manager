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
    
    if ($_SERVER['REQUEST_METHOD']=='POST'){

      //Connect to db
      require ('./mysqli_connect.php');
      
      //Data validation 
      if ( !empty($_POST['user']) && !empty($_POST['pass']) ) {
        
        $user = mysqli_real_escape_string($dbc, trim($_POST['user']));
        $pass = mysqli_real_escape_string($dbc, trim($_POST['pass']));

        //Check the user and the password
        $q= "SELECT user from users where user='$user' and password=SHA1('$pass')";
        $r = @mysqli_query($dbc, $q);
        $num = @mysqli_num_rows($r);

        if ($num==1){

        //Do session stuff
          $_SESSION['user']=$_POST['user'];

          $t="SELECT type from users where user='$user'";
          $type= @mysqli_query($dbc, $t); 
          $tnum= @mysqli_num_rows($type);

          if ($tnum==1){

            //Do session stuff
            

            $row = mysqli_fetch_array($type, MYSQLI_NUM);
            
            $_SESSION['type']=$row[0];

            if(strtolower($row[0])=='student'){
              header ('Location: index_student.php');
              mysqli_close($dbc);
			        exit();
            }elseif(strtolower($row[0])=='teacher'){
              header ('Location: index_teacher.php');
              mysqli_close($dbc);
			        exit();
            }elseif(strtolower($row[0])=='root'){
              header ('Location: index_root.php');
              mysqli_close($dbc);
			        exit();
            }

          }
        }else{
          $error='<p class="text-danger">The user does not match the password </p>';
        }
      }
      //Close the connection with db 
      mysqli_close($dbc);
    }

	?>
    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">
          <?php
          if(!empty($error)){
            echo $error;
          } 
          ?>
          <form action="" method="post">
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="inputUser" name="user" class="form-control" placeholder="User" required="required" autofocus="autofocus" value="<?php 
                        if(isset($_POST['user'])){
                            echo $_POST['user'];
                        }?>">
                <label for="inputUser">User</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="inputPassword" name="pass" class="form-control" placeholder="Password" required="required">
                <label for="inputPassword">Password</label>
              </div>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="remember-me">
                  Remember Password
                </label>
              </div>
            </div>
            <input type="submit" class="btn btn-primary btn-block" value="Login">
          </form>
          <div class="text-center">
            <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    
  </body>
  
</html>
