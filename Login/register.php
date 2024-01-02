<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $password = md5($_POST['password']);
    $level = $_POST['level'];

    $cek_user = "SELECT * FROM user WHERE username = '$username'";
    $hasil_cek = $db->query($cek_user);

    if ($hasil_cek->num_rows==1) {
        $gagal= "Data gagal disimpan! Duplicate " . $username;
    }else {
        $query = "INSERT INTO user (username, nama, password, level) VALUES ('$username', '$nama', '$password', '$level')";
        if ($db->query($query) === TRUE) {
            header("Location: login.php"); //redirect
            exit;
        } else {
            echo "Error: " . $query . "<br>" . $db->error;
        }
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

    <title>Register </title>
</head>
<body>
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h3 class="text-center fw-medium">SISTEM INFORMASI INVENTORI JURUSAN TEKNOLOGI INFORMASI</h3>
          <img src="../assets/img/442.png" alt="Image" class="img" style="width: 80%; margin-left:2.5rem;">
        </div>
        <div class="col-md-6 contents">
            <div class="row justify-content-center">
                <div class="col-md-10">
                <div class="mb-4">
                    <h3>Registration</h3>
                    <p>Mulai Pengelolaan Stok Anda: Registrasi di Sini.</p> 
                    <?php
                        if(isset($gagal)): ?>
        
                        <div class="alert alert-danger" role="alert">
                            <?=$gagal?>
                        </div>
                    <?php endif ?>
                </div>
                <form action="" method="POST">
                    <div class="form-group first mb-3">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" required>
                    </div>
                    <div class="form-group first mb-3">
                      <label for="username">Username:</label>
                      <input type="number" class="form-control" name="username" id="username" required>
                    </div>
                    <!-- <small class="d-block text-center mt-3">Do you have an account? <a href="login.php">* Username harus berupa NIM atau NIP</a></small> -->
                    <small class="d-block text-end mb-3 fw-bold" style="color: #9E9FA5;">* Username harus berupa NIM atau NIP</small>
                    <div class="form-group last mb-4">
                      <label for="password">Password:</label>
                      <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="form-group mt-3 mb-4">
                        <select name="level" id="level" class="form-control" style="background: #edf2f5;">
                          <option selected disabled>Pilih Kategori</option>
                          <option value="dosen">Dosen</option>
                          <option value="mahasiswa">Mahasiswa</option>
                        </select>
                    </div>
                  
                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-block btn-warning">Create an Account</button>
                    </div>
                    <small class="d-block text-center mt-3">Do you have an account? <a href="login.php">Log in Now!</a></small>
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