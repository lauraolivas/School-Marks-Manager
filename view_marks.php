<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>School Marks Manager - View marks</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

  </head>

  <body id="page-top">
    <?php
    session_start();
    require ('./mysqli_connect.php');
    if(!empty($_SESSION['user']) && ($_SESSION['type']=='teacher'||$_SESSION['type']=='root')){
      if(!empty($_GET['subject'])){
        $subject=mysqli_real_escape_string($dbc, trim($_GET['subject']));
      }else{
        echo '<p class="text-danger">ERROR: Choose the subject</p>';
        header("Location: subjects_teacher.php");
        exit;
      }
      $user=mysqli_real_escape_string($dbc, trim($_SESSION['user']));
            $iq = "SELECT ID FROM subjects where teacher='$user'";
            $ir=mysqli_query($dbc, $iq);
            
            //$said=mysqli_num_rows($ir);
            //print_r($ir);
            $dropdown="";
            //print_r($sid);
     while($sid=mysqli_fetch_array($ir, MYSQLI_ASSOC)){
                
                $dropdown.='<a class="dropdown-item" href="subjects_teacher.php?subject='.$sid['ID'].'">'.$sid['ID'].'</a>
                  <div class="dropdown-divider"></div>';
      }
      
      if(!empty($_GET['tasktype'])){
        
        $tasktype=mysqli_real_escape_string($dbc, trim($_GET['tasktype']));
        $display = 20;
        if (isset($_GET['p']) && is_numeric($_GET['p'])) { 
          $pages = $_GET['p'];
        } else {
          $iq = "SELECT COUNT(u.user) FROM users inner join subjects_users as su on u.user=su.user WHERE su.subjectid='$subject'";
          $ir = @mysqli_query ($dbc, $iq);
          $numrecs = @mysqli_fetch_array ($ir, MYSQLI_NUM);
          $records = $numrecs[0];
          
          
          if ($records > $display) { 
            $pages = ceil ($records/$display);
          } else {
            $pages = 1;
          }
        }
        
        if (isset($_GET['s']) && is_numeric($_GET['s'])) {
          $start = $_GET['s'];
        }else{
          $start = 0;
        }
      
        $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'ln';
        switch ($sort) {
          case 'fn':
            $order_by = 'firstname ASC';
            break;
          case 'ln':
            $order_by = 'lastname ASC';
            break;
          case 'm':
            $order_by = 'marks ASC';
            break;
            case 'd':
            $order_by = 'description ASC';
            break;
            case 'e':
            $order_by = 'evaluation ASC';
            break;
          default:
            $order_by = 'lastname ASC';
            $sort = 'ln';
          break;
        }
        //echo $order_by;
        //echo $start;
        //echo $display;
        $tableq = "SELECT u.user,u.firstname,u.lastname,m.marks,m.description,m.evaluation FROM users as u inner join subjects_users as su inner join marks as m on u.user=su.user and u.user=m.userid WHERE u.type='student' and su.subjectid='$subject' and m.taskname='$tasktype' ORDER BY $order_by LIMIT $start, $display";		
        $tabler = @mysqli_query ($dbc, $tableq); 
        $theader='<thead>
                    <tr>
                      <th>Edit</th>
                      <th>Delete</th>
                      <th><a href="view_marks.php?subject='.$subject.'&tasktype='.$_GET['tasktype'].'&sort=fn">First name</th>
                      <th><a href="view_marks.php?subject='.$subject.'&tasktype='.$_GET['tasktype'].'&sort=ln">Last name</th>
                      <th><a href="view_marks.php?subject='.$subject.'&tasktype='.$_GET['tasktype'].'&sort=m">Mark</th>
                      <th><a href="view_marks.php?subject='.$subject.'&tasktype='.$_GET['tasktype'].'&sort=d">Description</th>
                      <th><a href="view_marks.php?subject='.$subject.'&tasktype='.$_GET['tasktype'].'&sort=e">Evaluation</th>
                  </thead>';
        $tbody='';
        while ($numrecs = mysqli_fetch_array ($tabler, MYSQLI_ASSOC))  {
            $tbody = $tbody.'<tr>
            <td><a href="edit_mark.php?subject='.$subject.'&tasktype='.$_GET['tasktype'].'&user=' . $numrecs['user'] . '">Edit</a></td>
            <td><a href="delete_mark.php?subject='.$subject.'&tasktype='.$_GET['tasktype'].'&user=' . $numrecs['user'] . '">Delete</a></td>
            <td>' . $numrecs['firstname'] . '</td>
            <td>' . $numrecs['lastname'] . '</td>
            <td>' . $numrecs['marks'] . '</td>
            <td>' . $numrecs['description'] . '</td>
            <td>' . $numrecs['evaluation'] . '</td>
          </tr>';
        } 
        mysqli_free_result ($tabler);
        mysqli_close($dbc);
        
        if ($pages > 1) {
          
          $current_page = ($start/$display) + 1;
          
          if ($current_page != 1) {
            $previous= '<a href="table_student.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">&laquo;</a> ';
          }
          
          
          if ($current_page != $pages) {
            $next= '<a href="table_student.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">&raquo;</a>';
          }
          
          
        } 
      }else{
        $jq = "SELECT name FROM tasktypes where subjectid='$subject'";
        $jr = @mysqli_query ($dbc, $jq);
        $bgs=['bg-danger','bg-warning','bg-success','bg-primary'];
        $i=0;
        $iconc='';
        while($jarray = @mysqli_fetch_array ($jr, MYSQLI_ASSOC)) {
          $iconc.='<div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white '.$bgs[$i].' o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fas fa-fw fa-graduation-cap"></i>
              </div>
              <div class="mr-5">'.$jarray['name'].'</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="view_marks.php?subject='.$subject.'&tasktype='.$jarray['name'].'">
              <span class="float-left">View</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>';
        $i++;
        }
      }
      
    
    ?>
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="index_teacher.php">School Marks Manager</a>
      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <span class="badge badge-danger">9+</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-envelope fa-fw"></i>
            <span class="badge badge-danger">7</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#">Settings</a>
            <a class="dropdown-item" href="#">Activity Log</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>

    </nav>

    <div id="wrapper">

       <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index_teacher.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link <?php if(!empty($dropdown)&&$dropdown!=""){echo "dropdown-toggle";} ?>" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Subjects</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <?php
            if(!empty($dropdown)&&$dropdown!=""){
                echo $dropdown;
            }else{
                echo '<a class="dropdown-item" href="There are not subjects">Login</a>
                <div class="dropdown-divider"></div>';
            }
                        ?>
                    </div>
                </li>
            </ul>


      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

          <!-- Students  -->
          <div class="row">
          <?php
          if(!empty($iconc)&&$iconc!=""){
                echo $iconc;
          }
            ?>
          </div>
          <?php if(!empty($_GET['tasktype'])){ ?>
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
              Students</div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <?php
                  if (!empty($theader)&&!empty($tbody)){
                    echo $theader.$tbody;
                  }
                  ?>
                </table>
                <?php
                  if(!empty($previous)){
                    echo $previous;
                  }
                  
                    if ($pages > 1) {
                      // Make all the numbered pages:
                      for ($i = 1; $i <= $pages; $i++) {
                        if ($i != $current_page) {
                          echo '<a href="table_student.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
                        } else {
                          echo $i . ' ';
                        }
                      } 
                    }
                  
                  if(!empty($next)){
                    echo $next;
                  }
                ?>
              </div>
            </div>
          </div>
                <?php } ?>
        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © School Marks Manager 2019</span>
            </div>
          </div>
        </footer>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-danger text-white" href="logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>-->

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="js/demo/datatables-demo.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
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
  </body>

</html>
    
