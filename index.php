<?php
session_start();

require 'config/config.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('location: login.php');
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Widgets</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <div class="content-wrapper" style="margin-left:0px !important;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <h1 style="text-align: center;">Blog Sites</h1>
      </div><!-- /.container-fluid -->
    </section>
    <?php

       $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
       $stmt->execute();
       $result = $stmt->fetchAll();
    
    ?>

    <!-- Main content -->
    <section class="content">
      <div class="row">
                <?php
                  $i = 1;
                  if($result) {
                    foreach ($result as $value) {
                  
                  ?> 
                    <div class="col-md-4">
                        <!-- Box Comment -->
                        <div class="card card-widget">
                          <div class="card-header">
                          <div class="card-title" style="text-align: center !important;float:none">
                              <h2><?php echo $value['title']; ?></h2>
                          </div>
                            <!-- /.user-block -->
                        
                            <!-- /.card-tools -->
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                            <a href="detail.php?id=<?php echo $value['id']; ?>">
                               <img src="admin/images/<?php echo $value['image']?>" alt="" height="150" width="150" style="height: 220px !important">
                            </a>
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                   </div>
                  <?php
                    $i++;
                    }
                  }
                ?>
      <!-- /.row -->
      <div class="row">
        
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <div>
  <!-- Main Footer -->
  <footer class="main-footer" style="margin-left: 0px;">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <a href="logout.php" class="btn btn-default" type="button">Logout</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2023 <a href="#">A Programmer</a>.</strong> Blog App
  </footer>
</div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
