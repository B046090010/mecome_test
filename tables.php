<?php 
include_once('db/db_connect.php');

if($_GET['start']!=NULL && ($_GET['end']!=NaN))
  $start=$_GET['start'];
else 
  $start=20200101;
if($_GET['end']!=NULL && ($_GET['end']!=NaN))
  $end=$_GET['end'];
else
  $end=20200610;
$start=strval($start);
$end=strval($end);

$start=substr($start,0,4)."-".substr($start,4,2)."-".substr($start,6,2);
$end=substr($end,0,4)."-".substr($end,4,2)."-".substr($end,6,2);


$main=input($_GET['main']);
$middle=input($_GET['middle']);
$detail=input($_GET['detail']);
$area=input($_GET['area']);
$country=input($_GET['country']);
$town=input($_GET['town']);
$select=$_GET['select'];
$group=$_GET['group'];
$order=$_GET['order'];
$limit=$_GET['limit'];

$output=Tables($_GET['start'],$_GET['end'],$main,$middle,$detail,$area,$country,$town,$select,$group,$order,$limit);


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Mecome - Tables</title>

  <!-- Custom fonts for this template -->
  <link href="vendor1/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor1/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- other resource -->

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">


</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Mecome </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMenu" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-clipboard-list" aria-hidden="true"></i>
          <span>Menu</span>
        </a>
        <div id="collapseMenu" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
          <a class="nav-link" href="tables.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span>
          </a>
          <a class="nav-link" href="prediction.php">
            <i class="fas fa-rocket" aria-hidden="true"></i>
            <span>Prediction</span>
          </a>
          <a class="nav-link" href="seatmap.php">
            <i class="fa fa-map-pin" aria-hidden="true"></i>
            <span>Seatmap</span>
          </a>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Time
      </div>

      <!-- Nav Item - time Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStart" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-calendar" aria-hidden="true"></i>
            <span>Duration</span>
        </a>

        <div id="collapseStart" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <?php echo "<input type='text' class='form-control' id='tableStart' value=".$start." />"?>
            <div class="span text-center text-white" >To</div>
            <?php echo "<input type='text' class='form-control' id='tableEnd' value=".$end." />"?>
        </div>
      </li>
      <!-- Nav Item - store Collapse Menu -->

      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Store
      </div>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseArea" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fa fa-map-marker" aria-hidden="true"></i>
          <span>Area</span>
        </a>
        
        <div id="collapseArea" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <select id ="sarea" class="selectpicker form-control" data-live-search="true">
            <option data-tokens="" selected><?php remain ($_GET['area'])?></option>
            <option data-tokens="">-</option>
            <option data-tokens="">不分區</option>
            <option data-tokens="">三大區</option>
            <option data-tokens="">三重區</option>
            <option data-tokens="">中和區</option>
            <option data-tokens="">中壢區</option>
            <option data-tokens="">二安區</option>
            <option data-tokens="">佳恩區</option>
            <option data-tokens="">利民區</option>
            <option data-tokens="">加棟區</option>
            <option data-tokens="">南雅區</option>
            <option data-tokens="">台安區</option>
            <option data-tokens="">台灣區</option>
            <option data-tokens="">善耕區</option>
            <option data-tokens="">城康區</option>
            <option data-tokens="">大慶區</option>
            <option data-tokens="">家音區</option>
            <option data-tokens="">富國區</option>
            <option data-tokens="">延吉區</option>
            <option data-tokens="">悅康區</option>
            <option data-tokens="">新康區</option>
            <option data-tokens="">新杏區</option>
            <option data-tokens="">新竹區</option>
            <option data-tokens="">林口區</option>
            <option data-tokens="">桃園區</option>
            <option data-tokens="">桃康區</option>
            <option data-tokens="">正康區</option>
            <option data-tokens="">蘆洲區</option>
            <option data-tokens="">逢甲區</option>
            <option data-tokens="">閎安區</option>
            <option data-tokens="">鶯康區</option>
            <option data-tokens="">一安一區</option>
            <option data-tokens="">一安二區</option>
            <option data-tokens="">北市二區</option>
            <option data-tokens="">新莊一區</option>
            <option data-tokens="">新莊二區</option>
            <option data-tokens="">一安政昇區</option>
            <option data-tokens="">輔大美康區</option>
            <option data-tokens="">N/A</option>
          </select>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCountry" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fa fa-map-marker" aria-hidden="true"></i>
          <span>Country</span>
        </a>
        <div id="collapseCountry" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <select id ="scountry" class="selectpicker form-control" data-live-search="true">
              <option data-tokens="" selected><?php remain ($_GET['country'])?></option>
              <option data-tokens="台">台北市</option>
              <option data-tokens="新">新北市</option>
              <option data-tokens="桃">桃園市</option>
              <option data-tokens="新">新竹市</option>
              <option data-tokens="新">新竹縣</option>
              <option data-tokens="苗">苗栗縣</option>
              <option data-tokens="台">台中市</option>
              <option data-tokens="彰">彰化縣</option>
              <option data-tokens="南">南投縣</option>
              <option data-tokens="雲">雲林市</option>
              <option data-tokens="嘉">嘉義市</option>
              <option data-tokens="台">台南市</option>
              <option data-tokens="高">高雄市</option>
              <option data-tokens="屏">屏東縣</option>
            </select>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTown" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fa fa-map-marker" aria-hidden="true"></i>
          <span>Town</span>
        </a>
        <div id="collapseTown" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <select id ="stown" class="selectpicker form-control" data-live-search="true">
            <option data-tokens="" selected><?php remain ($_GET['town'])?></option>
          </select>
        </div>
      </li>
      <!-- Nav Item - product Collapse Menu -->

      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Product
      </div>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMain" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fa fa-sitemap" aria-hidden="true"></i>
          <span>Main</span>
        </a>
        <div id="collapseMain" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <select id ="smain" class="selectpicker form-control" data-live-search="true">
              <option data-tokens="" selected><?php remain ($_GET['main'])?></option>
              <option data-tokens="中">中藥</option>
              <option data-tokens="美">美清</option>
              <option data-tokens="婦">婦嬰</option>
              <option data-tokens="食">食品</option>
              <option data-tokens="藥">藥品</option>
              <option data-tokens="日">日用百貨</option>
              <option data-tokens="保">保健食品</option>
              <option data-tokens="醫">醫療器材</option>
              <option data-tokens="奶">奶粉尿褲</option>
              <option data-tokens="其">其他</option>
              <option data-tokens="">N/A</option>
            </select>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMiddle" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fa fa-sitemap" aria-hidden="true"></i>
          <span>Middle</span>
          
        </a>
        <div id="collapseMiddle" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <select id="smiddle" class="selectpicker form-control" data-live-search="true">
            <option data-tokens="" selected><?php remain ($_GET['middle'])?></option>
          </select>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDetail" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fa fa-sitemap" aria-hidden="true"></i>
          <span>Detail</span>
        </a>
        <div id="collapseDetail" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <select id ="sdetail" class="selectpicker form-control" data-live-search="true">
              <option data-tokens="" selected><?php remain ($_GET['detail'])?></option>
            </select>
        </div>
      </li>
      <!-- Divider -->

      <hr class="sidebar-divider d-none d-md-block">
      <!-- search -->

      <button id="sendTable" type="button" class="btn btn-icon-split" >
        <span class="icon text-white-50">
          <i class="fas fa-arrow-right"></i>
        </span>
      </button>
      <p></p>

    

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>


    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <form class="form-inline">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
              <i class="fa fa-bars"></i>
            </button>
          </form>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>



            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Valerie Luna</span>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Tables</h1>
          <!-- Select option -->

          <div class ="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Select</div>
                                <select id ="select" class="selectpicker form-control" multiple>
                                    <option data-tokens="">Profit</option>
                                    <option data-tokens="">Sales Amount</option>
                                    <option data-tokens="">Quantity</option>
                                    <option data-tokens="">Percentage(Profit)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Group</div>
                      <select id ="group" class="selectpicker form-control">
                        <optgroup label="Duration">
                            <option>Year</option>
                            <option>Month</option>
                            <option>Day</option>
                        </optgroup>
                        <optgroup label="Location">
                            <option>Area</option>
                            <option>Country</option>
                            <option>Town</option>
                            <option>Store Name</option>
                        </optgroup>
                        <optgroup label="Product">
                            <option>Main Category</option>
                            <option>Middle Category</option>
                            <option>Detail Category</option>
                            <option>Product Name</option>
                        </optgroup>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Order</div>
                      <select id ="order" class="selectpicker form-control">
                        
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Limit</div>
                      <select id ="limit" class="selectpicker form-control">
                        <option data-tokens="">First 100 rows</option>
                        <option data-tokens="">Last 100 rows</option>
                        <option data-tokens="">All rows</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
         </div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables Result</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <?php
                        if($output){
                          foreach($output[0] as $key=>$value){
                            echo '<th>'.$key.'</th>';
                          }
                        }
                        else
                          echo '<th>none</th>';
                      ?>
                    </tr>
                  </thead>
                  
                  <tbody>
                    <?php
                        if($output){
                          foreach($output as $sub){
                            echo '<tr>';
                            foreach($sub as $key=>$value){
                              if ($key=="Profit(%)")
                                echo '<td>'.($value*100).'%</td>';
                              else
                                echo '<td>'.$value.'</td>';
                            }
                            echo '</tr>';
                          }
                        }
                        else
                          echo '<tr><td>none</td></tr>';
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

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
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor1/jquery/jquery.min.js"></script>
  <script src="vendor1/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor1/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor1/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor1/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <!-- additional -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

</body>

</html>
