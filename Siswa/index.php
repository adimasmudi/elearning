<?php
session_start();
include '../config/db.php';

if (@$_SESSION['Siswa']) {
?>
  <?php
  if (@$_SESSION['Siswa']) {
    $sesi = @$_SESSION['Siswa'];
  }

  $sql = mysqli_query($con, "SELECT * FROM tb_siswa
 WHERE id_siswa = '$sesi'") or die(mysqli_error($con));
  $data = mysqli_fetch_array($sql);


  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>E-learning | <?= $data['nama_siswa']; ?></title>
    <!-- plugins:css -->

    <link rel="stylesheet" href="../vendor/node_modules/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../vendor/node_modules/simple-line-icons/css/simple-line-icons.css">
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="../vendor/node_modules/font-awesome/css/font-awesome.min.css" />
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../vendor/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../vendor/images/favicon.png" />
    <link href="../vendor/sweetalert/sweetalert.css" rel="stylesheet" />
    <script src="../vendor/js/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/jquery/jquery-2.0.2.min.js"></script>
    <script type="text/javascript" src="../vendor/ckeditor/ckeditor.js"></script>
    <link rel="stylesheet" type="text/css" href="../vendor/css/jquery.dataTables.css">
    <script type="text/javascript" src="js/main.js"></script>
    <link href="css/ujian.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../vendor/login/css/main.css?v=<?php echo time(); ?>">
    <script type="text/javascript" src="js/sidein_menu.js"></script>



    <script>
      function disableBackButton() {
        window.history.forward();
      }
      setTimeout("disableBackButton()", 0);
    </script>



  </head>

  <body>


    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-left col-lg-6" style="background-color: #517fd4">
          <a class="navbar-brand brand-logo" href="index.php" style="font-family:Aegyptus;font-weight: bold;font-size: 30px;">
            <img src="../vendor/images/MTC.png" class="animated-logo" alt="logo" style="height: 45px;width: 45px;border-radius: 10px;"> <b style="color:white">M'TECH ONLINE CLASS</b>
          </a>

        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center col-lg-6" style="background-color: #517fd4">

          <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                <i class="mdi mdi-bell-ring"></i>
                <span class="count"><?= $jmlh ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <a href="?page=materi" class="dropdown-item">
                  <p class="mb-0 font-weight-normal float-left"><b><?= $jmlh; ?></b> Mata Pelajaran
                  </p>
                  <span class="badge badge-pill badge-warning float-right">Lihat Semua</span>
                </a>
                <?php
                foreach ($sqlmtr as $row) { ?>
                  <a href="?page=materi&act=mapel&ID=<?= $row['id_mapel']; ?>&mp=<?= $row['mapel']; ?>" class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon">
                        <img src="../vendor/images/img_Guru/<?= $row['foto']; ?>" alt="logo" style="height:40px;width: 40px;">
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <h6 class="preview-subject font-weight-medium"> <?= $row['mapel']; ?></h6>
                      <p class="font-weight-light small-text">
                        <?= $row['nama_guru']; ?>
                      </p>
                    </div>
                  </a>

                  <div class="dropdown-divider"></div>



                <?php
                }
                ?>

              </div>
            </li>

            <li class="nav-item d-none d-lg-block">
              <a class="nav-link" href="#">
                <img class="img-xs rounded-circle" src="../vendor/images/img_Siswa/<?= $data['foto']; ?>" alt="">
              </a>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <div class="nav-link">
                <div class="profile-image"> <img src="../vendor/images/img_Siswa/<?= $data['foto']; ?>" alt="image" style="border:3px solid black;" /> <span class="online-status online"></span> </div>
                <div class="profile-name">
                  <p class="name"><?= $data['nama_siswa']; ?></p>
                  <p class="designation">Siswa</p>
                  <div class="badge badge-teal mx-auto mt-3"><?= $data['status']; ?></div>
                </div>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php"><img class="menu-icon" src="../vendor/images/menu_icons/01.png" alt="menu icon"><span class="menu-title">DASHBOARD</span></a>
            </li>




            <li class="nav-item purchase-button">
              <a class="nav-link" href="logout.php?ID=<?php echo $data['id_siswa'] ?>">
                Keluar</a>
            </li>

          </ul>
        </nav>


        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>

    <!-- container-scroller -->
    <!-- plugins:js -->

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->

    <script src="../vendor/js/jquery.dataTables.js"></script>
    <script src="../vendor/node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendor/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../vendor/sweetalert/sweetalert.min.js"></script>
    <script src="script1.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="../vendor/js/off-canvas.js"></script>
    <script src="../vendor/js/misc.js"></script>
    <script src="../vendor/ckeditor/plugins/ckeditor_wiris/integration/WIRISplugins.js?viewer=image"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <!-- End custom js for this page-->


    <script>
      CKEDITOR.replace('ckeditor', {
        // uiColor:'#40c4ff'
        filebrowserImageBrowseUrl: '../vendor/kcfinder'
      });
    </script>
    <script>
      $(document).ready(function() {
        $('#data').DataTable();
      });
    </script>


    <!-- <script src="js/jquery-scrolltofixed.js" type="text/javascript"></script>
<script src="js/masonry.pkgd.min.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src="js/common.js"></script>
<script src="js/main.js"></script>
<script src="js/cookieList.js"></script>
<script src="js/backend.js"></script> -->




  </body>

  </html>


<?php
} else {

  include 'modul/500.html';

  // echo "<script>
  // window.location='../index.php';</script>";

}
