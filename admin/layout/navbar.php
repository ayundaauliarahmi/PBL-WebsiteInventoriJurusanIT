<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="index.php?page=barang" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <?php
        if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'mahasiswa' || $_SESSION['level'] == 'dosen') {
        ?>
          <i class="far fa-bell"></i>
        <?php
        }
        ?>
        <?php
        $c = mysqli_connect("localhost:3307", "root", "", "db_inventory");

        if ($_SESSION['level'] == 'admin') {

          $ambil2 = mysqli_query($c, "SELECT * FROM barang WHERE stock < 1");
          $jumlah_notifikasi = mysqli_num_rows($ambil2);
          $display_badge = ($jumlah_notifikasi > 0);
        ?>
          <?php if ($display_badge) : ?>
            <span class="badge badge-danger navbar-badge"><?= $jumlah_notifikasi ?></span>
          <?php else : ?>
            <span class="badge badge-light navbar-badge"></span>
        <?php endif;
        }
        ?>

        <?php
        if ($_SESSION['level'] == 'mahasiswa' || $_SESSION['level'] == 'dosen') {
          $currentUsername = $_SESSION['username'];

          $ambil3 = mysqli_query($c, "SELECT * FROM pinjaman INNER JOIN barang ON pinjaman.kode_brg = barang.kode_brg WHERE pinjaman.username = '$currentUsername' AND pinjaman.status IS NULL");
          $jmlh_notifikasi = mysqli_num_rows($ambil3);
          $disply_badge = ($jmlh_notifikasi > 0);
        ?>
          <?php if ($disply_badge) : ?>
            <span class="badge badge-danger navbar-badge"><?= $jmlh_notifikasi ?></span>
          <?php else : ?>
            <span class="badge badge-light navbar-badge"></span>
          <?php endif; ?>

        <?php
        }
        ?>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="#" class="dropdown-item">
          <!-- Message Start -->
          <?php
          if ($_SESSION['level'] == 'admin') {
          ?>
            <div role="alert">
              <?php
              foreach ($ambil2 as $data) {
                $barang = $data['nama_brg'];
                $jenis_brg = $data['jenis_brg'];

              ?>
                <div class="alert alert-warning mt-2 px-3" style="width: 250px; height: auto;" role="alert">
                  <strong>Perhatian!</strong>
                  <br>Stock Barang
                  <?= $barang; ?>
                  <br>
                  <?= $jenis_brg; ?> telah habis
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php
              }
              ?>
            </div>
          <?php
          } elseif ($_SESSION['level'] == 'mahasiswa' || $_SESSION['level'] == 'dosen') {
          ?>
            <div role="alert">
              <?php
              foreach ($ambil3 as $data) {
                $barang = $data['nama_brg'];
                $jenis_brg = $data['jenis_brg'];
                $tgl_dikembalikan = $data['tgl_kembali'];

              ?>
                <div class="alert alert-warning mt-2 px-3" style="width: 250px; height: auto;" role="alert">
                  <strong>Perhatian!</strong>
                  <br>
                  Segera Kembalikan
                  <?= $barang; ?>

                  <?= $jenis_brg; ?>
                  <br> karena tenggat pengembalian <br>
                  <?= $tgl_dikembalikan; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php
              }
              ?>
            </div>
          <?php
          }
          ?>
          <!-- Message End -->
        </a>

        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
      </div>
    </li>

    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <div class="media d-flex align-items-center">
          <div class="user-panel d-flex mr-3">
            <?php
            if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'pimpinan') {
            ?>
              <img src="../app/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            <?php
            } elseif ($_SESSION['level'] == 'mahasiswa') {
            ?>
              <img src="../app/dist/img/user1-128x128.jpg" class="img-circle elevation-2" alt="User Image">
            <?php
            } elseif ($_SESSION['level'] == 'dosen') {
            ?>
              <img src="../app/dist/img/user8-128x128.jpg" class="img-circle elevation-2" alt="User Image">
            <?php
            }
            ?>
          </div>
          <div class="media-body">
            <h3 class="dropdown-item-title d-block text-dark mb-0">
              <?php echo $_SESSION['nama']; ?>
            </h3>
          </div>
        </div>
      </a>

      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <!-- Pesan -->
        <!-- Divider -->
        <a href="#" class="dropdown-item">
          <div class="media">
            <!-- Isi pesan -->
          </div>
        </a>
        <!-- Divider -->
        <!-- Opsi Setting -->
        <a href="#" class="dropdown-item">
          <div class="media">
            <div class="icon mr-2">
              <!-- Ikon setting -->
              <i class="fas fa-cog"></i>
            </div>
            <div class="media-body">
              <h3 class="dropdown-item-title">
                Setting
              </h3>
            </div>
          </div>
        </a>
        <!-- Divider -->
        <!-- Opsi Logout -->
        <a href="../Login/logout.php" class="dropdown-item" onclick="return confirm('Yakin ingin keluar?')">
          <div class="media">
            <div class="icon mr-2">
              <!-- Ikon logout -->
              <i class="fas fa-sign-out-alt"></i>
            </div>
            <div class="media-body">
              <h3 class="dropdown-item-title">
                Logout
              </h3>
            </div>
          </div>
        </a>
      </div>
    </li>
  </ul>
</nav>