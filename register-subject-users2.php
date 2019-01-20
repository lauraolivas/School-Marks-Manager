<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>School Marks Manager - Register student</title>

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
  if(!empty($_SESSION['user'])&&($_SESSION['type']=="teacher"||$_SESSION['type']=="root")){
    if ($_SERVER['REQUEST_METHOD']=='POST'){
      //Connect to db
      require ('./mysqli_connect.php');
      
      $user = mysqli_real_escape_string($dbc, trim($_POST['user']));
      //Check the subject
      $uq= "SELECT user from subjects_users where user='$user'";
      $ur = @mysqli_query($dbc, $uq);
      $unum = @mysqli_num_rows($ur);
      
      if($unum==1){
        $error="<p>The user already exists, try another one</p>";
      }elseif(!filter_var($_POST['subjectID'],FILTER_VALIDATE_SUBJECTID)){
        $error="<p>Please, insert a valid subjectID</p>";
      }else{
        $si = mysqli_real_escape_string($dbc, trim($_POST['subjectID']));
          
        // Make the insert query:
        $q = "INSERT INTO `subjects_users`(`user`, `subjectid`) VALUES ('$user', '$si')";		
        $r = @mysqli_query ($dbc, $q); 
        if ($r) {
          echo ' <div class="container" id="container">
                  <div class="card card-register mx-auto mt-5">
                    <div class="card-header">The student has been registered!</div>
                    <div class="card-body">
                      <div class="text-center">
                        <p class="d-block small mt-3">The register has been made correctly.</p>
                      </div>
                    </div>
                  </div>
                </div>';
        }else{
          $error= '<p>You must contact with the technic.</p>';
        }
      }
    }
  
  ?>
    <div class="container" id="econtainer" style="<?php if(!empty($error)){ echo 'display:block;'; }else{echo 'display:none';}?>">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header text-danger">ERROR</div>
          <div class="card-body">
            <div class="text-center" id="error">
            <?php
                  if(!empty($error)){
                    echo $error;
                  }
            ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container" id="rcontainer">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">Register a student</div>
        <div class="card-body">
          
          <form action="" method="post">
            <div class="form-group">
            
              <div class="form-row" id="error">
                <div class="col-md-6">
                  <div class="form-label-group">
                  
                <input type="text" name="user" id="user" class="form-control" placeholder="User" required="required" autofocus="autofocus" value="<?php if(isset($_POST['user'])){
                            echo $_POST['user'];
                        }?>">
                <label for="user">User</label>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="subjectid" name="subjectid" class="form-control" placeholder="SubjectID" required="required" autofocus="autofocus" value="<?php if(isset($_POST['subjectid'])){
                            echo $_POST['subjectid'];
                        }?>">
                    <label for="subjectid">SubjectID</label>
                  </div>
                </div>
              </div>
            </div>
            
            <input type="submit" id="register" class="btn btn-primary btn-block" value="Register">
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="index_teacher.php">Back to dashboard</a>
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
                  <p>That is not a user for this subject</p>
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
