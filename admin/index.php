<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('location: login.php');
}

?>


<?php include('header.html')?>
    <div class="content">
      <div class="container-fluid">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Blog Listings</h3>
            </div>
            <?php
              if(!empty($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
              }else{
                $pageno = 1;
              }
              $numOfRecs = 3;
              $offSet = ($pageno - 1 ) * $numOfRecs;

              if(empty($_POST['search'])) {
                
              $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
              $stmt->execute();
              $rawResult = $stmt->fetchAll();
              $total_pages = ceil(count($rawResult) / $numOfRecs);

              $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offSet,$numOfRecs");
              $stmt->execute();
              $result = $stmt->fetchAll();
              }else{
              $searchKey = $_POST['search'];
              $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
              $stmt->execute();
              $rawResult = $stmt->fetchAll();
              $total_pages = ceil(count($rawResult) / $numOfRecs);

              $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offSet,$numOfRecs");
              $stmt->execute();
              $result = $stmt->fetchAll();
              }
            
            ?>
            <div class="card-body">
              <div>
                <a href="add.php" class="btn btn-success" type="button">New Blog Post</a>
              </div><br>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width: 10px">ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th style="width: 40px">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  
                  <?php
                  $i = 1;
                  if($result) {
                    foreach ($result as $value) {
                  
                  ?> 
                    <tr>
                      <td><?= $i?></td>
                      <td><?= $value['title']?></td>
                      <td><?= substr($value['content'],0,50)?></td>
                      <td>
                      <div class="btn btn-group">
                        <div class="container">
                          <a href="edit.php?id=<?= $value['id'] ?>" class="btn btn-warning" type="button">Edit</a>
                        </div>
                        <div class="container">
                          <a href="delete.php?id=<?= $value['id'] ?>" class="btn btn-danger" type="button"
                          onclick="return confirm('Are you sure you want to delete this item?');"
                          >Delete</a>
                        </div>
                      </div>
                      </td>
                    </tr>
                  <?php
                    $i++;
                    }
                  }
                  ?>
                </tbody>
              </table>
              <br>
              <div style="float:right">
                  <nav aria-label="Page navigation example">
                    <ul class="pagination">
                      <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                      <li class="page-item<?php if($pageno <= 1){echo "disabled";} ?>">
                        <a class="page-link" href="<?php if($pageno <= 1){echo '#';}else{echo "?pageno=".($pageno-1);} ?>">previous</a>
                      </li>
                      <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                      <li class="page-item <?php if($pageno >= $total_pages){echo "disabled";} ?>">
                        <a class="page-link" href="<?php if($pageno >= $total_pages){echo '#';}else{echo "?pageno=".($pageno+1);} ?>">next</a>
                      </li>
                      <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages;?>">Last</a></li>
                    </ul>
                  </nav>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
 <?php include('footer.html') ?>
