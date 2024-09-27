<?php

// Cek peran pengguna yang login
$username = $_SESSION['username'];
$userLevel = $_SESSION['level'];

//Barang_masuk
$query = $db->query("SELECT SUM(qty) as jumlah FROM brg_masuk");
$jumlah = mysqli_fetch_assoc($query);

//Total Peminjaman Barang
if ($userLevel == 'admin' || $userLevel == 'pimpinan') {
  //Total Belum Mengembalikan barang

  $query = $db->query("SELECT COUNT(*) as jumlah FROM pinjaman WHERE status IS NULL");
  $barang = mysqli_fetch_assoc($query);
} else {
  //Total Peminjaman Barang sesuai akun
  $query = $db->query("SELECT COUNT(*) as jumlah FROM pinjaman WHERE username = '$username'");
  $pinjam = mysqli_fetch_assoc($query);
}

//Sudah dikembalikan user dan belum
if ($userLevel == 'mahasiswa' || $userLevel == 'dosen') {
  //Sudah dikembalikan
  $query = $db->query("SELECT COUNT(*) as jumlah FROM pinjaman WHERE status = 'Dikembalikan' AND username = '$username'");
  $sudah = mysqli_fetch_assoc($query);

  //Belum Dikembalikan
  $query = $db->query("SELECT COUNT(*) as jumlah FROM pinjaman WHERE status IS NULL AND username = '$username'");
  $belum = mysqli_fetch_assoc($query);
}

//Mutasi Barang
$query = $db->query("SELECT SUM(qty) as jumlah FROM brg_mutasi");
$mutasi = mysqli_fetch_assoc($query);

//User
$query = $db->query("SELECT COUNT(*) as jumlah FROM user WHERE level = 'mahasiswa' || level = 'dosen'");
$user = mysqli_fetch_assoc($query);

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
  case 'list':
    # list data barang
?>
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <?php
        if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'pimpinan') {
        ?>
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?= $jumlah['jumlah'] ?></h3>
                  <p>Barang Masuk</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-boxes-stacked"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?= $mutasi['jumlah'] ?></h3>
                  <p>Mutasi Barang</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-dolly"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?= $barang['jumlah'] ?></h3>
                  <p>Belum Pengembalian Barang</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-people-carry-box"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner text-light">
                  <h3><?= $user['jumlah'] ?></h3>
                  <p>User Registration</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
              </div>
            </div>
          </div>

        <?php
        }
        ?>
        <?php
        if ($_SESSION['level'] == 'dosen' || $_SESSION['level'] == 'mahasiswa') {
          $nama = $_SESSION['nama'];
          // Mengatur pesan selamat datang berdasarkan level pengguna
          $welcomeMessage = ($_SESSION['level'] == 'dosen') ? " $nama" : " $nama";
        ?>
          <!-- Kotak pesan selamat datang -->
          <div class="row">
            <div class="col-lg-12 mt-3">
              <div class="alert alert-info" role="alert">
                <div class="d-flex align-items-start">
                  <h3 class="px-3 mt-3"><strong>Hi,<?php echo $welcomeMessage; ?></strong></h3>
                </div>
                <div class="d-flex align-items-start px-3">
                  <p>Nikmati layanan peminjaman dan pengembalian barang dengan nyaman!</p>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-4 col-12">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?= $pinjam['jumlah'] ?></h3>
                  <p>Total Peminjaman</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-boxes-stacked"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-12">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?= $sudah['jumlah'] ?></h3>
                  <p>Sudah Dikembalikan</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-people-carry-box"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-12">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?= $belum['jumlah'] ?></h3>
                  <p>Belum Dikembalikan</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-box"></i>
                </div>
              </div>
            </div>
          </div>

        <?php
        }
        ?>
        <!-- /.row -->
        <div class="row">
          <section class="col-lg-8 connectedSortable">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="example" class="table table-bordered table-striped text-center">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Jenis</th>
                          <!-- <th>Kategori</th> -->
                          <th>Stock</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        if ($userLevel === 'admin' || $userLevel === 'pimpinan') {
                          // Jika pengguna adalah admin, mereka dapat melihat semua data
                          $query = "SELECT * FROM barang order by nama_brg";
                        } else {
                          // Jika pengguna bukan admin
                          $query = "SELECT * FROM barang
                          WHERE kategori = 'Bisa Dipinjam'
                          ORDER BY nama_brg";
                        }

                        // $query = "SELECT * FROM barang order by nama_brg";
                        $result = $db->query($query);

                        $nomor = 1;
                        foreach ($result as $row) :
                        ?>
                          <tr>
                            <td class="text-nowrap"><?= $nomor++ ?></td>
                            <td class="text-nowrap"><?= $row['kode_brg'] ?></td>
                            <td class="text-nowrap"><?= $row['nama_brg'] ?></td>
                            <td class="text-nowrap"><?= $row['jenis_brg'] ?></td>
                            <!-- <td class="text-nowrap"><?= $row['kategori'] ?></td> -->
                            <td class="text-nowrap"><?= $row['stock'] ?></td>
                            <td class="text-nowrap">
                              <?php
                              if ($row['stock'] <= 0) {
                                echo "Barang Tidak Tersedia";
                              } else {
                                echo "Barang Tersedia";
                              }
                              ?>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </section>
          <!-- /.col -->

          <section class="col-lg-4 connectedSortable">
            <!-- Calendar -->
            <div class="card bg-gradient-light">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <button type="button" class="btn btn-light btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>

              <!-- /.card-body -->
            </div>
            <div class="card-footer bg-transparent" style="display: none;">
              <div class="row">
                <div class="col-4 text-center">
                  <div id="sparkline-1"></div>
                  <div class="text-white">Visitors</div>
                </div>
                <!-- ./col -->
                <div class="col-4 text-center">
                  <div id="sparkline-2"></div>
                  <div class="text-white">Online</div>
                </div>
                <!-- ./col -->
                <div class="col-4 text-center">
                  <div id="sparkline-3"></div>
                  <div class="text-white">Sales</div>
                </div>
                <!-- ./col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card -->
          </section>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

<?php
    break;
}
?>