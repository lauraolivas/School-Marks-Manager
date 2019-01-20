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
      
      $user = mysqli_real_escape_string($dbc, trim($_POST['Name']));
      //Check the subject
      $uq= "SELECT Name from subjects where Name='$name'";
      $ur = @mysqli_query($dbc, $uq);
      $unum = @mysqli_num_rows($ur);
      
      if($unum==1){
        $error="<p>The subject already exists, try another one</p>";
      }elseif(!filter_var($_POST['ID'],FILTER_VALIDATE_ID)){
        $error="<p>Please, insert a valid ID</p>";
      }elseif($_POST['inputTeacher']!==$_POST['confirmTeacher']){
        $error="<p>The Teacher does not match</p>";
      }else{
        $i = mysqli_real_escape_string($dbc, trim($_POST['ID']));
        $t = mysqli_real_escape_string($dbc, trim($_POST['teacher']));
          
        // Make the insert query:
        $q = "INSERT INTO `subjects`(`ID`, `Name`, `teacher`) VALUES ('$name', '$i','$t')";		
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
                  
                <input type="text" name="user" id="Name" class="form-control" placeholder="Name" required="required" autofocus="autofocus" value="<?php if(isset($_POST['Name'])){
                            echo $_POST['Name'];
                        }?>">
                <label for="Name">Name</label>
                  </div>
                </div>
              </div>
              
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="ID" name="ID" class="form-control" placeholder="SubjectID" required="required" autofocus="autofocus" value="<?php if(isset($_POST['ID'])){
                            echo $_POST['ID'];
                        }?>">
                    <label for="ID">SubjectID</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="teacher" class="form-control" name="teacher" placeholder="Teacher" required="required" value="<?php if(isset($_POST['teacher'])){
                            echo $_POST['teacher'];
                        }?>">
                    <label for="teacher">Teache</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" required="required" value="<?php if(isset($_POST['email'])){
                            echo $_POST['email'];
                        }?>">
                <label for="inputEmail">Email address</label>
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
                  <p>That is not a subject</p>
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
