<?php

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../Login/login.php");
    exit;
}

include '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<!--HeaderStart-->
<?php include 
  'layout/header.php';
?>
<!--HeaderEnd-->

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php
    include 'layout/navbar.php';
  ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
   <?php 
      include 'layout/sidebar.php';
    ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <?php
       $p=isset($_GET['page']) ? $_GET['page'] : 'barang'; //ternary

        if ($p=='barang') include 'barang/barang.php';
        if ($p=='data_barang') include 'dashboard/data_barang.php';
        if ($p=='barang_masuk') include 'dashboard/barang_masuk.php';
        if ($p=='mutasi_barang') include 'dashboard/mutasi_barang.php';
        if ($p=='pengembalian_barang') include 'dashboard/pengembalian_barang.php';
        if ($p=='data_ruangan') include 'ruangan/data_ruangan.php';
        if ($p=='peminjaman') include 'peminjaman/peminjaman.php';
    ?>
    <!-- /.content -->
  </div>
  
  <footer class="main-footer">
    <strong>Copyright &copy; 2023.</strong>
    Temukan lebih banyak informasi di halaman kami.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

 <!--JavaScript-->
 <script>
  $(document).ready(function() {
    $('.js-example-basic-single').select2();
  });
</script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
  new DataTable('#example');
</script>
<!-- jQuery -->
<script src="../app/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../app/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../app/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../app/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../app/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../app/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../app/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../app/plugins/moment/moment.min.js"></script>
<script src="../app/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../app/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../app/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../app/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../app/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../app/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../app/dist/js/pages/dashboard.js"></script>
<!-- DataTables  & Plugins -->
<script src="../app/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../app/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../app/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../app/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../app/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../app/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../app/plugins/jszip/jszip.min.js"></script>
<script src="../app/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../app/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../app/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../app/plugins/datatables-buttons/js/buttons.print.min.js"></script>
</body>
</html>
