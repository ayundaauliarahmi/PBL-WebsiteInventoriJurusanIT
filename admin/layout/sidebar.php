<?php
// Mendapatkan nama file halaman saat ini
$page = basename($_SERVER['SCRIPT_NAME']);
?>
<!-- Brand Logo -->
<div class="d-flex">
  <img src="../assets/img/logo.png" alt="TI Logo" class="brand-image mb-2" style="opacity: .8; width: 90%; height:auto;">
</div>

<div class="sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="index.php?page=barang" class="nav-link <?= ($page === 'index.php' && isset($_GET['page']) && $_GET['page'] === 'barang') ? 'active' : ''; ?>">
          <i class="nav-icon fa-solid fa-box-open"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <?php
      if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'pimpinan') {
      ?>
        <li class="nav-item">
          <a href="index.php?page=data_barang" class="nav-link <?= ($page === 'index.php' && isset($_GET['page']) && $_GET['page'] === 'data_barang') ? 'active' : ''; ?>">
            <i class="nav-icon fa-solid fa-boxes-stacked"></i>
            <p>Data Barang</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?page=barang_masuk" class="nav-link <?= ($page === 'index.php' && isset($_GET['page']) && $_GET['page'] === 'barang_masuk') ? 'active' : ''; ?>">
            <i class="nav-icon fa-solid fa-download"></i>
            <p>Barang Masuk</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?page=mutasi_barang" class="nav-link <?= ($page === 'index.php' && isset($_GET['page']) && $_GET['page'] === 'mutasi_barang') ? 'active' : ''; ?>">
            <i class="nav-icon fa-solid fa-dolly"></i>
            <p>Mutasi Barang</p>
          </a>
        </li>
      <?php
      }
      ?>

      <li class="nav-item">
        <a href="index.php?page=peminjaman" class="nav-link <?= ($page === 'index.php' && isset($_GET['page']) && $_GET['page'] === 'peminjaman') ? 'active' : ''; ?>">
          <i class="nav-icon fas fa-columns"></i>
          <p>Peminjaman Barang</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="index.php?page=pengembalian_barang" class="nav-link <?= ($page === 'index.php' && isset($_GET['page']) && $_GET['page'] === 'pengembalian_barang') ? 'active' : ''; ?>">
          <i class="nav-icon fa-solid fa-people-carry-box"></i>
          <p>Pengembalian Barang</p>
        </a>
      </li>
      <?php
      if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'pimpinan') {
      ?>
        <li class="nav-item">
          <a href="index.php?page=data_ruangan" class="nav-link <?= ($page === 'index.php' && isset($_GET['page']) && $_GET['page'] === 'data_ruangan') ? 'active' : ''; ?>">
            <i class="nav-icon fa-solid fa-warehouse"></i>
            <p>Data Ruangan</p>
          </a>
        </li>
      <?php
      }
      ?>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>