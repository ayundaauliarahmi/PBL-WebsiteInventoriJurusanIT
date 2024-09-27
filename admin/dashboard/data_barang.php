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
                        <h1 class="m-3">Data Barang</h1>
                    </div><!-- /.col -->
                    <?php
                    if ($_SESSION['level'] == 'admin') {

                    ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php?page=data_barang&aksi=input" class="btn btn-primary m-3 fa-plus" data-toggle="modal" data-target="#inputBarang"> Tambah Barang</a></li>
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
                                <div class="table-responsive">
                                    <form id="cetakForm" action="./cetak/cetak.php" method="POST">
                                        <button type="submit" class="btn btn-danger btn-sm ml-auto mb-4" form="cetakForm">
                                            <i class="fa-solid fa-print"></i>
                                            Cetak
                                        </button>
                                    </form>
                                    <table id="example" class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Jenis</th>
                                                <th>Kategori</th>
                                                <th>Stock</th>
                                                <th>Satuan</th>
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
                                                    <?php
                                                    if ($_SESSION['level'] == 'admin') {

                                                    ?>
                                                        <td class="text-nowrap">
                                                            <a href="proses_data_barang.php?proses=edit&kode_brg=<?= $row['kode_brg'] ?>" class="btn btn-warning" data-toggle="modal" data-target="#editBarang<?= $row['kode_brg'] ?>">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="proses_data_barang.php?proses=delete&kode_brg=<?= $row['kode_brg'] ?>" onclick="return confirm('Apakah yakin hapus data ini?')" class="btn btn-danger">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
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
                        <h5 class="modal-title" id="inputBarangLabel">Input Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="proses_data_barang.php?proses=insert" method="POST">
                            <div class="form-group mt-3 mb-2">
                                <label for="kode_brg">Kode Barang :</label>
                                <input type="text" class="form-control" name="kode_brg" id="kode_brg" required>
                            </div>
                            <div class="form-group mt-3 mb-2">
                                <label for="nama_brg">Nama Barang :</label>
                                <input type="text" class="form-control" name="nama_brg" id="nama_brg" required>
                            </div>
                            <div class="form-group mt-3 mb-2">
                                <label for="jenis_brg">Jenis Barang :</label>
                                <input type="text" class="form-control" name="jenis_brg" id="jenis_brg" required>
                            </div>
                            <div class="form-group mt-3 mb-2">
                                <label for="kategori">Kategori :</label>
                                <select name="kategori" id="kategori" class="form-control">
                                    <option selected disabled>Pilih Kategori</option>
                                    <option value="Bisa Dipinjam">Barang Bisa Dipinjam</option>
                                    <option value="Tidak Bisa Dipinjam">Barang Tidak Bisa Dipinjam</option>
                                </select>
                            </div>
                            <div class="form-group mt-3 mb-2">
                                <label for="stock">Stock Barang :</label>
                                <input type="text" class="form-control" name="stock" id="stock" required>
                            </div>
                            <div class="form-group mt-3 mb-2">
                                <label for="satuan">Satuan Barang :</label>
                                <input type="text" class="form-control" name="satuan" id="satuan" required>
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
        $query = "SELECT * FROM barang";
        $result = $db->query($query);

        foreach ($result as $row) :
        ?>
            <div class="modal fade" id="editBarang<?= $row['kode_brg'] ?>" tabindex="-1" role="dialog" aria-labelledby="editBarangLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editBarangLabel">Edit Barang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="proses_data_barang.php?proses=update" method="POST">
                                <div class="form-group mt-3 mb-2">
                                    <label for="kode_brg">Kode Barang:</label>
                                    <input type="text" class="form-control" name="kode_brg" id="kode_brg" value="<?= $row['kode_brg']; ?>" required readonly>
                                </div>
                                <div class="form-group mt-3 mb-2">
                                    <label for="nama_brg">Nama Barang:</label>
                                    <input type="text" class="form-control" name="nama_brg" id="nama_brg" value="<?= $row['nama_brg']; ?>" required>
                                </div>
                                <div class="form-group mt-3 mb-2">
                                    <label for="jenis_brg">Jenis Barang:</label>
                                    <input type="text" class="form-control" name="jenis_brg" id="jenis_brg" value="<?= $row['jenis_brg'] ?>" required>
                                </div>
                                <div class="form-group mt-3 mb-2">
                                    <label for="kategori">Kategori Barang:</label>
                                    <select name="kategori" id="kategori" class="form-control">
                                        <option value="Bisa Dipinjam" <?= ($row['kategori'] == 'Bisa Dipinjam') ? 'selected' : '' ?>>Bisa Dipinjam</option>
                                        <option value="Tidak Bisa Dipinjam" <?= ($row['kategori'] == 'Tidak Bisa Dipinjam') ? 'selected' : '' ?>>Tidak Bisa Dipinjam</option>
                                    </select>
                                </div>
                                <div class="form-group mt-3 mb-2">
                                    <label for="stock">Stock Barang:</label>
                                    <input type="text" class="form-control" name="stock" id="stock" value="<?= $row['stock'] ?>" readonly>
                                </div>
                                <div class="form-group mt-3 mb-2">
                                    <label for="satuan">Satuan Barang:</label>
                                    <input type="text" class="form-control" name="satuan" id="satuan" value="<?= $row['satuan'] ?>" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

<?php
        break;
}
?>