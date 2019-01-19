<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>School Marks Manager - Insertar notas</title>

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
        if(!empty($_SESSION['user'])&&$_SESSION['type']='teacher'){
            
            

            $kq = "SELECT name FROM tasktypes";
            $kr =  @mysqli_query ($dbc, $kq);
            $krecs = @mysqli_fetch_array ($kr, MYSQLI_NUM);
            //echo count($krecs);
            //print_r($krecs);
            for($o=0;$o<count($krecs);$o++){
                $option="<option>".$krecs[$o]."</option>";
            }

            $display = 20;
            if (isset($_GET['p']) && is_numeric($_GET['p'])) { 
                $pages = $_GET['p'];
            } else {
                $iq = "SELECT COUNT(user) FROM users WHERE type='student'";
                $ir = @mysqli_query ($dbc, $iq);
                $irecs = @mysqli_fetch_array ($ir, MYSQLI_NUM);
                $records = $irecs[0];

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
                default:
                    $order_by = 'lastname ASC';
                    $sort = 'ln';
                    break;
            }

            $tableq = "SELECT firstname,lastname FROM users WHERE type='student' ORDER BY $order_by LIMIT $start, $display";		
            $tabler = @mysqli_query ($dbc, $tableq); 

            $theader='<thead>
                <tr>
                    <th><a href="diego.php?sort=fn">First name</th>
                    <th><a href="diego.php?sort=ln">Last name</th>
                    <th>Mark</th>
                </tr>
            </thead>';

        

            $tbody='';
            $j=1;
            while ($recs = mysqli_fetch_array ($tabler, MYSQLI_ASSOC)) {
                $tbody .='<tr>
                <td>' . $recs['firstname'] . '</td>
                <td>' . $recs['lastname'] . '</td>
                <td><input type="text"';
                if(!empty($merror)){
                    $tbody.=$merror;
                } 
                $tbody.='name="mark'.$j.'" id="mark'.$j.'" class="form-control" value="';
                if(isset($_POST["mark$j"])){
                    $tbody.= $_POST["mark$j"];
                }
                $tbody.='"></td>';
                $j++;
            } 
            if ($_SERVER['REQUEST_METHOD']=='POST'){
                

                if(empty($POST['description'])){
                    $desc_error='<p class="text-danger">Rellene el campo de descripción</p>';
                    $derror='required="required"';
                }else{
                    $description = mysqli_real_escape_string($dbc, trim($_POST['description']));
                }

                $m=1;
                while ($recs2 = mysqli_fetch_array ($tabler, MYSQLI_ASSOC)) {
                    $insq = "INSERT INTO marks VALUES()";
			        $insr = @mysqli_query ($dbc, $insq);
                    $m++;
                }
            }
            mysqli_free_result ($tabler);
            mysqli_close($dbc);


            if ($pages > 1) {

                $current_page = ($start/$display) + 1;

                if ($current_page != 1) {
                    $previous= '<a href="modifier_delete_student.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">&laquo;</a> ';
                }


                if ($current_page != $pages) {
                    $next= '<a href="modifier_delete_student.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">&raquo;</a>';
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
                        <a class="dropdown-item" href="#">Messages Received</a>
                        <a class="dropdown-item" href="#">Sent Messages</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Privates</a>
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
                        <button class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
                    </div>
                </li>
            </ul>

        </nav>

        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="sidebar navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.html">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Pages</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <h6 class="dropdown-header">Login Screens:</h6>
                        <a class="dropdown-item" href="login.html">Login</a>
                        <a class="dropdown-item" href="register.html">Register</a>
                        <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header">Other Pages:</h6>
                        <a class="dropdown-item" href="404.html">404 Page</a>
                        <a class="dropdown-item" href="blank.html">Blank Page</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="charts.html">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Qualification Graphics</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tables.html">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Tables</span></a>
                </li>
            </ul>

            <div id="content-wrapper">

                <div class="container-fluid">

                    <!-- Breadcrumbs-->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Professor Name</li>
                    </ol>

                    <!-- Icon Cards-->
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 mb-3">
                            <div class="card text-white bg-primary o-hidden h-100">
                                <div class="card-body">
                                    <div class="card-body-icon">
                                        <i class="fas fa-fw fa-list"></i>
                                    </div>
                                    <div class="mr-5">Exams</div>
                                </div>
                                <a class="card-footer text-white clearfix small z-1">

                                    <span class="float-left">View Details</span>
                                    <span class="float-right">
                                        <i class="fas fa-angle-right"></i>
                                    </span>
                                </a>

                            </div>
                        </div>

                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-table"></i>
                            Students Table</div>
                        <div class="card-body">
                            <form method='post' action="">
                                <?php if(!empty($desc_error)){echo $desc_error;} ?>
                                <label for="description">Description: </label>
                                <input type="text" name="description" id="description" <?php if(!empty($derror)){echo $derror;} ?> class="form-control" value="<?php if(isset($_POST["description"])){echo $_POST["description"];}?>">
                                <br>

                                <label for="tasktype">Task type: </label>
                                <select class="form-control" id="tasktype" name="tasktype">
                                    <?php 
                                        if(!empty($option)){
                                            echo $option;
                                        }
                                    ?>
                                </select><br>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                                                echo '<a href="modifier_delete_student.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
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
                                <input type="submit" class="btn btn-primary" value="Submit marks"/>
                            </form>
                        </div>
                    </div>

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
                            <button class="btn btn-primary" onclick="">Logout</button>
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

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin.min.js"></script>

            <!-- Demo scripts for this page-->
            <script src="js/demo/datatables-demo.js"></script>
            <script src="js/demo/chart-area-demo.js"></script>
            
            </body>

        </html>