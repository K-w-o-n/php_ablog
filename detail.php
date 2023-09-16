<?php 
require 'config/config.php';

session_start();

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('location: login.php');
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt->execute();
$result = $stmt->fetchAll();

$blogId = $_GET['id'];

$stmtcm = $pdo->prepare("SELECT * FROM commets WHERE post_id=$blogId");
$stmtcm->execute();
$cmResult = $stmtcm->fetchAll();



$authorId = $cmResult[0]['author_id'];
$stmtau = $pdo->prepare("SELECT * FROM users WHERE id=$authorId");
$stmtau->execute();
$auResult = $stmtau->fetchAll();


if($_POST) {
  $comment = $_POST['comment'];
  $stmt = $pdo->prepare("INSERT INTO commets(content,author_id,post_id) VALUES (:content,:author_id,:post_id)");
  $result = $stmt->execute([
    ':content' => $comment,
    ':author_id' => $_SESSION['user_id'],
    ':post_id' => $blogId,
  ]);
  if($result) {
    header('location: detail.php?id='.$blogId);
  }
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
<div class="">

  <div class="">

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Box Comment -->
          <div class="card card-widget">
            <div class="card-header">
            <div class="card-title" style="text-align: center !important;float:none">
                <h2><?php echo $result[0]['title']; ?></h2>
             </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <img src="admin/images/<?php echo $result[0]['image']?>" alt="" >
              <br><br>
              <p><?php echo $result[0]['content']; ?></p>
              <h1>Comments</h1><hr>
              <a href="index.php" type="button" class="btn btn-default">Go Back</a>
            </div>
            <!-- /.card-body -->
            <div class="card-footer card-comments">
              <div class="card-comment">
                <!-- User image -->

                <div class="comment-text" style="margin-left:0px !important">
                  <span class="username">
                    <?php echo $auResult[0]['name']; ?>
                    <span class="text-muted float-right"><?php echo $cmResult[0]['created_at']; ?></span>
                  </span><!-- /.username -->
                    <?php echo $cmResult[0]['content']; ?>
                </div>
                <!-- /.comment-text -->
              </div>   
            </div>
            <!-- /.card-footer -->
            <div class="card-footer">
              <form action="" method="post">
                
                <!-- .img-push is used to add margin to elements next to floating images -->
                <div class="img-push">
                  <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                </div>
              </form>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        
      </div>
      <!-- /.row -->

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
