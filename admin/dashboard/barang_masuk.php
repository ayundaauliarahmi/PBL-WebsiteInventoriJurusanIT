<?php
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
        # list data barang
?>

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-3">Data Barang Masuk</h1>
                    </div><!-- /.col -->
                    <?php
                    if ($_SESSION['level'] == 'admin') {

                    ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php?page=data_barang&aksi=input" class="btn btn-primary m-3 fa-plus" data-toggle="modal" data-target="#inputBarang"> Tambah Data</a></li>
                            </ol>
                        </div><!-- /.col -->
                    <?php
                    }
                    ?>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <button class="btn btn-danger btn-sm ml-auto mb-4" data-toggle="modal" data-target="#cetak">
                                    <i class="fa-solid fa-print"></i>
                                    Cetak
                                </button>
                                <div class="table-responsive">
                                    <table id="example" class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Masuk</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Jenis</th>
                                                <th>Kategori</th>
                                                <th>Qty</th>
                                                <th>Satuan</th>
                                                <th>Ruangan Awal</th>
                                                <th>Penerima</th>
                                                <?php
                                                if ($_SESSION['level'] == 'admin') {

                                                ?>
                                                    <th>Aksi</th>
                                                <?php
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM brg_masuk 
                                    INNER JOIN barang ON brg_masuk.kode_brg = barang.kode_brg 
                                    
                                    ORDER BY barang.nama_brg";
                                            $result = $db->query($query);

                                            $nomor = 1;
                                            foreach ($result as $row) :
                                            ?>
                                                <tr>
                                                    <td class="text-nowrap"><?= $nomor++ ?></td>
                                                    <td class="text-nowrap"><?php $tgl_masuk = $row['tgl_masuk'];
                                                                            echo date("d-M-Y", strtotime($tgl_masuk)) ?></td>
                                                    <td class="text-nowrap"><?= $row['kode_brg'] ?></td>
                                                    <td class="text-nowrap"><?= $row['nama_brg'] ?></td>
                                                    <td class="text-nowrap"><?= $row['jenis_brg'] ?></td>
                                                    <td class="text-nowrap"><?= $row['kategori'] ?></td>
                                                    <td class="text-nowrap"><?= $row['qty'] ?></td>
                                                    <td class="text-nowrap"><?= $row['satuan'] ?></td>
                                                    <td class="text-nowrap"><?= $row['id_ruangan'] ?></td>
                                                    <td class="text-nowrap"><?= $row['penerima'] ?></td>
                                                    <?php
                                                    if ($_SESSION['level'] == 'admin') {

                                                    ?>
                                                        <td class="text-nowrap">
                                                            <a href="proses_barang_masuk.php?proses=edit&id=<?= $row['id'] ?>" class="btn btn-warning" data-toggle="modal" data-target="#editBarang<?= $row['id'] ?>"><i class="fas fa-edit"></i></a>
                                                            <a href="proses_barang_masuk.php?proses=delete&id=<?= $row['id'] ?>" onclick="return confirm('Apakah yakin hapus data ini?')" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                        </td>
                                                    <?php
                                                    }
                                                    ?>
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

        <!-- Formulir input barang -->
        <div class="modal fade" id="inputBarang" tabindex="-1" role="dialog" aria-labelledby="inputBarangLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inputBarangLabel">Input Barang Masuk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="proses_barang_masuk.php?proses=insert" method="POST">
                            <div class="form-group mt-3 mb-2">
                                <label for="tgl_masuk">Tanggal Masuk :</label>
                                <input type="date" class="form-control" name="tgl_masuk" id="tgl_masuk">
                            </div>
                            <div class="form-group mt-3 mb-2">
                                <label>Nama Barang</label>
                                <select name="kode_brg" class="custom-select form-control">
                                    <option selected disabled>Pilih barang</option>
                                    <?php
                                    $barangs = $db->query("SELECT * FROM barang");
                                    foreach ($barangs as $data) { ?>
                                        <option value="<?= $data['kode_brg'] ?>">
                                            <?= $data['kode_brg'] ?> - <?= $data['nama_brg'] ?> - <?= $data['jenis_brg'] ?> - <?= $data['kategori'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group mt-3 mb-2">
                                <label for="qty">Kuantitas Barang :</label>
                                <input type="text" class="form-control" name="qty" id="qty" required>
                            </div>
                            <div class="form-group mt-3 mb-2">
                                <label for="id_ruangan">Lokasi Awal :</label>
                                <select name="id_ruangan" id="id_ruangan" class="form-control">
                                    <option selected disabled>Pilih Kategori</option>
                                    <option value="Gudang">Gudang</option>
                                </select>
                            </div>
                            <div class="form-group mt-3 mb-2">
                                <label for="penerima">Penerima :</label>
                                <input type="text" class="form-control" name="penerima" id="penerima" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal untuk Edit Barang -->
        <?php
        $query = "SELECT * FROM brg_masuk";
        $result = $db->query($query);

        foreach ($result as $row) :
            $id = $row['id'];
        ?>
            <div class="modal fade" id="editBarang<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="editBarangLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editBarangLabel">Edit Barang Masuk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="proses_barang_masuk.php?proses=update" method="POST">
                                <div class="form-group mt-3 mb-2">
                                    <!-- Menampilkan data yang ingin di-edit -->
                                    <label for="kode_brg">Barang</label>
                                    <input type="text" id="kode_brg" name="kode_brg" class="form-control" value="<?= $row['kode_brg'] ?>" readonly>
                                </div>
                                <div class="form-group mt-3 mb-2">
                                    <label for="qty">Kuantitas Barang :</label>
                                    <input type="text" class="form-control" name="qty" id="qty" value="<?= $row['qty'] ?>" required>
                                </div>
                                <div class="form-group mt-3 mb-2">
                                    <label for="penerima">Penerima Barang :</label>
                                    <input type="text" class="form-control" name="penerima" id="penerima" value="<?= $row['penerima'] ?>" required>
                                </div>
                                <input type="hidden" name="id" value="<?= $id ?>"> <!-- Menambahkan input hidden untuk menyimpan nilai id -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        endforeach;
        ?>

        <!-- ModalCetak -->
        <div class="modal fade" id="cetak" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header no-bd">
                        <h5 class="modal-title">
                            <span class="fw-mediumbold">
                                Cetak Data Barang Masuk</span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action='./cetak/cetak_brg_masuk.php' method="post">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Bulan</label>
                                    <div class="form-group form-group-default">
                                        <input id="addName" type="month" name="bulan" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer no-bd">
                                <button type="submit" name="cetak" class="btn btn-primary">Cetak</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<?php
        break;
}
?>