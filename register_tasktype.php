<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>School Marks Manager - Register tasktype</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

  </head>

  <body class="bg-dark">
  <?php
   //Connect to db
   session_start();
   require ('./mysqli_connect.php');
 
  if(!empty($_SESSION['user'])&&($_SESSION['type']=="teacher"||$_SESSION['type']=="root")){
    if ($_SERVER['REQUEST_METHOD']=='POST'){

      if(!empty($_GET['subject'])){
        $subject=mysqli_real_escape_string($dbc, trim($_GET['subject']));
      }else{
        header("Location: subjects_teacher.php");
      }

     
      
      $name = mysqli_real_escape_string($dbc, trim($_POST['name']));

        // Make the insert query:
        $inq = "INSERT INTO `tasktypes`(`name`,`subjectid`) VALUES ('$name','$subject')";		
        $inr = @mysqli_query ($dbc, $inq); 
        if ($inr) {
          echo ' <div class="container" id="container">
                  <div class="card card-register mx-auto mt-5">
                    <div class="card-header">The tasktype has been registered!</div>
                    <div class="card-body">
                      <div class="text-center">
                        <p class="d-block small mt-3">The register has been made correctly.</p>
                        <a href="subjects_teacher.php" class="d-block small mt-3"
                      </div>
                    </div>
                  </div>
                </div>';
        }else{
          $error= '<p>You must contact with the technic.</p>';
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
        <div class="card-header">Register a tasktype</div>
        <div class="card-body">
          
          <form action="" method="post">
            <div class="form-group">
              <div class="form-label-group">
                  
                <input type="text" name="name" id="name" class="form-control" placeholder="Name" required="required" autofocus="autofocus" value="<?php if(isset($_POST['name'])){
                            echo $_POST['name'];
                        }?>">
                <label for="name">Name</label>
              </div>
            </div>
            <input type="submit" id="register" class="btn btn-primary btn-block" value="Register">
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="subjects_teacher.php">Back to subjects</a>
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