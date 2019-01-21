<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>School Marks Manager - Edit teacher</title>

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
  if(!empty($_SESSION['user'])&&$_SESSION['type']=="root"){
      //Connect to db
      require ('./mysqli_connect.php');
      
      if ( isset($_GET['user']) ) { 
        $user = $_GET['user'];
      } elseif (isset($_POST['user'])) {
        $user = $_POST['user'];
      } else { 
        echo '<div class="container" id="container">
            <div class="card card-register mx-auto mt-5">
              <div class="card-header text-danger">ERROR</div>
              <div class="card-body">
                <div class="text-center">
                  <p>You must choose a teacher</p>
                  <a href="modifier_delete_teacher.php" class="d-block small mt-3">Back to the class list</a>
                </div>
              </div>
            </div>
          </div>';
          exit();
      }
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        if(!empty($_POST['inputPassword'])&&empty($_POST['confirmPassword'])){
          $error='<p>Fill the confirm password</p>';
        }elseif($_POST['inputPassword']!=$_POST['confirmPassword']){
          $error='<p>Fill the confirm password correctly</p>';
        }else{
          if(!empty($_POST['user'])){
            $u = mysqli_real_escape_string($dbc, trim($_POST['user']));
            
          }else{
            $uvq="SELECT user FROM users WHERE user='$user'";
            $uvr = @mysqli_query($dbc, $uvq);
            $uvrow = mysqli_fetch_array($uvr, MYSQLI_NUM);
            $u=$uvrow[0];
          }
            
          //Check the user
          $uq= "SELECT user from users where user='$u'";
          $ur = @mysqli_query($dbc, $uq);
          $unum = @mysqli_num_rows($ur);
          
          if($u==$user||$unum==0){
            if(!empty($_POST['firstName'])){
              $fn = mysqli_real_escape_string($dbc, trim($_POST['firstName']));
            }else{
              $fnq="SELECT firstname FROM users WHERE user='$user'";
              $fnr = @mysqli_query($dbc, $fnq);
              $fnrow = mysqli_fetch_array($fnr, MYSQLI_NUM);
              $fn=$fnrow[0];
            }
            if(!empty($_POST['lastName'])){
              $ln = mysqli_real_escape_string($dbc, trim($_POST['lastName']));
            }else{
              $lnq="SELECT lastname FROM users WHERE user='$user'";
              $lnr = @mysqli_query($dbc, $lnq);
              $lnrow = mysqli_fetch_array($lnr, MYSQLI_NUM);
              $ln=$lnrow[0];
            }
            
            if(!empty($_POST['email'])){
              $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
            }else{
              $evq="SELECT email FROM users WHERE user='$user'";
              $evr = @mysqli_query($dbc, $evq);
              $evrow = mysqli_fetch_array($evr, MYSQLI_NUM);
              $e=$evrow[0];
            }
            if(!empty($_POST['phone'])){
              $p = mysqli_real_escape_string($dbc, trim($_POST['phone']));
            }else{
              $pq="SELECT phone FROM users WHERE user='$user'";
              $pr = @mysqli_query($dbc, $pq);
              $prow = mysqli_fetch_array($pr, MYSQLI_NUM);
              $p=$prow[0];
            }
          
            if(!empty($_POST['inputPassword'])){
              $ipt = mysqli_real_escape_string($dbc, trim($_POST['inputPassword']));
              $ip='SHA("'.$ipt.'")';
            }else{
              $ipq="SELECT password FROM users WHERE user='$user'";
              $ipr = @mysqli_query($dbc, $ipq);
              $iprow = mysqli_fetch_array($ipr, MYSQLI_NUM);
              $ip=$iprow[0];
            }
          
          
          $q = "UPDATE `users` SET `user`='$u',`firstname`='$fn',`lastname`='$ln',`email`='$e',`password`=$ip,`type`='teacher',`phone`=$p WHERE user='$user' LIMIT 1";
          $r = @mysqli_query ($dbc, $q);
              
          if (mysqli_affected_rows($dbc) == 1) { 
            $update='<a href="table_teacher.php" class="d-block small mt-3">Back to the class list</a>';
          } else { 
            $error= '<p>You must speak with the technic</p>';
          }
        
        }elseif($unum==1){
          $error="<p>The user already exists, try another one</p>";
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
      <div class="container" id="ucontainer" style="<?php if(!empty($update)){ echo 'display:block;'; }else{echo 'display:none';}?>">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header text-danger">Has been update correctly!</div>
          <div class="card-body">
            <div class="text-center" id="update">
            <?php
                  if(!empty($update)){
                    echo $update;
                  }
            ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container" id="rcontainer">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">Edit a teacher</div>
        <div class="card-body">
          
          <form action="" method="post">
            <div class="form-group">
            
              <div class="form-row" id="error">
                <div class="col-md-6">
                  <div class="form-label-group">
                  
                <input type="text" name="user" id="user" class="form-control" placeholder="User" autofocus="autofocus" value="<?php if(isset($_POST['user'])){
                            echo $_POST['user'];
                        }?>">
                <label for="user">User</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="phone" class="form-control" name="phone" placeholder="Phone" value="<?php if(isset($_POST['phone'])){
                            echo $_POST['phone'];
                        }?>">
                    <label for="phone">Phone</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First name" autofocus="autofocus" value="<?php if(isset($_POST['firstName'])){
                            echo $_POST['firstName'];
                        }?>">
                    <label for="firstName">First name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="lastName" class="form-control" name="lastName" placeholder="Last name" value="<?php if(isset($_POST['lastName'])){
                            echo $_POST['lastName'];
                        }?>">
                    <label for="lastName">Last name</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" value="<?php if(isset($_POST['email'])){
                            echo $_POST['email'];
                        }?>">
                <label for="inputEmail">Email address</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" id="inputPassword" class="form-control" name="inputPassword" placeholder="Password">
                    <label for="inputPassword">Password</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" id="confirmPassword" class="form-control" name="confirmPassword" placeholder="Confirm password">
                    <label for="confirmPassword">Confirm password</label>
                  </div>
                </div>
              </div>
            </div>
            
            <input type="submit" id="register" class="btn btn-primary btn-block" value="Update">
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="<?php if($_SESSION['type']=='teacher'){ echo 'index_teacher.php';}elseif($_SESSION['type']=='root'){ echo 'index_root.php';} ?>">Back to dashboard</a>
            <a class="btn btn-danger text-white" href="logout.php">Logout</a>
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
                  <p>You are not a root</p>
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
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>-->
    
  </body>

</html>
