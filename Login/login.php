<?php
   session_start();
   include '../koneksi.php';

   if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username=$_POST['username'];
        $password=md5($_POST['password']);

        $sql ="SELECT * FROM user WHERE username='$username' AND password='$password'";
        $result =$db->query($sql);
          
        $data = mysqli_fetch_array($result); 
      if ($result->num_rows == 1) {
        $_SESSION['login'] = TRUE;
        $_SESSION['username'] = $username;
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['level'] = $data['level'];
          header("Location: ../admin/index.php?page=barang");
          exit;
      }else{
        $gagal= "email/password is wrong!";
    }
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="../assets/fonts/icomoon/style.css">

    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <title>Login </title>
</head>
<body>
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h3 class="text-center">SISTEM INFORMASI INVENTORI JURUSAN TEKNOLOGI INFORMASI</h3>
          <img src="../assets/img/442.png" alt="Image" class="img" style="width: 80%; margin-left:2.5rem;">
        </div>
        <div class="col-md-6 contents mt-5">
            <div class="row justify-content-center">
                <div class="col-md-10">
                <div class="mb-4">
                    <h3 class="text-center mb-3">LOGIN</h3>
                    <p>Selamat datang ke Portal Inventori kami. Silakan masuk untuk mengakses manajemen stok.</p>
                    <?php
                    if(isset($gagal)): ?>
    
                    <div class="alert alert-danger" role="alert">
                        <?=$gagal?>
                    </div>
                    <?php endif ?>
                </div>
                <form action="" method="post">
                    <div class="form-group first mb-3">
                      <label for="username">Username:</label>
                      <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="form-group last mb-4">
                      <label for="password">Password:</label>
                      <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="d-flex align-items-center">
                      <button type="submit" class="btn btn-block btn-warning">Log In</button>
                    </div>
                    <small class="d-block text-center mt-3">Not registered? <a href="register.php">Register Now!</a></small>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--MyJavaScript-->
    <script src="../assets/js/jquery-3.3.1.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>
  </body>
</html>