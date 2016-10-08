<?php 
session_start();
if (!isset($_SESSION['user'])) {
  if (isset($_COOKIE['user'])) {
    $_SESSION['user'] = $_COOKIE['user'];
  }else{
    header('location:welcome.php');
    exit();
  }
}
if (isset($_SESSION['rem'])) {
  setcookie('user',$_SESSION['user'],time()+3600);
  unset($_SESSION['rem']);
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
  <!-- header部分 -->
  <?php require_once 'public/layouts/header.php' ?>

  <body>
  <!-- 导航栏 -->
  <?php require_once 'public/layouts/nav.php' ?>

  <!-- 页面主体内容 -->
    <div class="container">
      <div class="content">
          <div class="starter-template">
                <!-- 这里做了修改，其他地方自由发挥 -->
            <h1>Welcome To ShiYanLou</h1>
            <div class="jumbotron">
              <h1>Hello, <?php echo $_SESSION['user']; ?></h1>
              <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
              <p><a class="btn btn-primary btn-lg" href="http://www.shiyanlou.com" role="button">Learn more</a></p>
            </div>
          </div>  
      </div>
    </div><!-- /.container -->
    
    <!-- 网页底部 -->
    <?php require_once 'public/layouts/footer.php'; ?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="public/js/check.js"></script>
  </body>
</html>