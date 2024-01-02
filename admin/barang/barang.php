<?php

$query = $db->query("SELECT COUNT(*) as jumlah FROM barang");
$barang = mysqli_fetch_assoc($query);
$aksi=isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
        # list data barang
?>

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <!-- <div class="col-sm-6">
            <h1 class="m-3">Barang</h1>
          </div> -->
          <!-- <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item m-3"><a href="index.php?page=dashboard">Home</a></li>
            </ol>
          </div>/.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">
       <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $barang['jumlah']?></h3>

                <p>Barang Masuk</p>
              </div>
              <div class="icon">
                <i class="fa-solid fa-boxes-stacked"></i>
              </div>
              <a href="index.php?page=barang_masuk" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Mutasi Barang</p>
              </div>
              <div class="icon">
                <i class="fa-solid fa-dolly"></i>
              </div>
              <a href="index.php?page=mutasi_barang" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $barang['jumlah']?></h3>

                <p>Pengembalian Barang</p>
              </div>
              <div class="icon">
                <i class="fa-solid fa-people-carry-box"></i>
              </div>
              <a href="index.php?page=pengembalian_barang" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jenis</th>
                                        <th>Kategori</th>
                                        <th>Stock</th>
                                        <th>Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM barang order by nama_brg";
                                    $result = $db->query($query);

                                    $nomor = 1;
                                    foreach ($result as $row) :
                                    ?>
                                        <tr>
                                            <td class="text-nowrap"><?= $nomor++ ?></td>
                                            <td class="text-nowrap"><?= $row['kode_brg'] ?></td>
                                            <td class="text-nowrap"><?= $row['nama_brg'] ?></td>
                                            <td class="text-nowrap"><?= $row['jenis_brg'] ?></td>
                                            <td class="text-nowrap"><?= $row['kategori'] ?></td>
                                            <td class="text-nowrap"><?= $row['stock'] ?></td>
                                            <td class="text-nowrap"><?= $row['satuan'] ?></td>
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
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<?php
    break;
  }
?>