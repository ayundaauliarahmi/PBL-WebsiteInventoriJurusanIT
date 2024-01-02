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
                <h1 class="m-3">Data Peminjaman Barang</h1>
            </div><!-- /.col -->
            <?php
            if ($_SESSION['level'] == 'dosen' || $_SESSION['level'] == 'mahasiswa') {
            ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php?page=peminjaman" class="btn btn-primary m-3 fa-plus" data-toggle="modal" data-target="#inputBarang"> Tambah Data</a></li>
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
                            <table id="example" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIM / NIP</th>
                                        <th>Nama Barang</th>
                                        <?php
                                        if ($_SESSION['level'] == 'admin') {
                                        ?>
                                            <th>Kode Barang</th>
                                            <th>Jenis</th>
                                        <?php
                                        }
                                        ?>
                                        <th>Tanggal Peminjaman</th>
                                        <th>Batas Pengembalian</th>
                                        <th>Stock</th>
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
                                    // Cek peran pengguna yang login
                                    if ($_SESSION['level'] == 'mahasiswa') {
                                        $query = "SELECT * FROM pinjaman 
                                            INNER JOIN barang ON pinjaman.kode_brg = barang.kode_brg 
                                            INNER JOIN user ON pinjaman.nama = user.nama
                                            WHERE user.level = 'mahasiswa'
                                            ORDER BY pinjaman.tgl_peminjaman";
                                    } elseif ($_SESSION['level'] == 'dosen') {
                                        $query = "SELECT * FROM pinjaman 
                                            INNER JOIN barang ON pinjaman.kode_brg = barang.kode_brg 
                                            INNER JOIN user ON pinjaman.nama = user.nama
                                            WHERE user.level = 'dosen'
                                            ORDER BY pinjaman.tgl_peminjaman";
                                    } elseif ($_SESSION['level'] == 'admin') {
                                        $query = "SELECT * FROM pinjaman 
                                            INNER JOIN barang ON pinjaman.kode_brg = barang.kode_brg 
                                            INNER JOIN user ON pinjaman.nama = user.nama
                                            ORDER BY pinjaman.tgl_peminjaman";
                                    }

                                    $result = $db->query($query);

                                    $nomor = 1;
                                    foreach ($result as $row) :
                                    ?>
                                        <tr>
                                            <td class="text-nowrap"><?= $nomor++ ?></td>
                                            <td class="text-nowrap"><?= $row['nama'] ?></td>
                                            <td class="text-nowrap"><?= $row['username'] ?></td>
                                            <td class="text-nowrap"><?= $row['nama_brg'] ?></td>
                                            <?php
                                            if ($_SESSION['level'] == 'admin') {
                                            ?>
                                                <td class="text-nowrap"><?= $row['kode_brg'] ?></td>
                                                <td class="text-nowrap"><?= $row['jenis_brg'] ?></td>
                                            <?php
                                            }
                                            ?>
                                            <td class="text-nowrap"><?php $tgl_peminjaman = $row['tgl_peminjaman'];
                                                                    echo date("d-M-Y", strtotime($tgl_peminjaman)) ?></td>
                                            <td class="text-nowrap"><?php $tgl_kembali = $row['tgl_kembali'];
                                                                    echo date("d-M-Y", strtotime($tgl_kembali)) ?></td>
                                            <td class="text-nowrap"><?= $row['qty'] ?></td>
                                            <?php
                                            if ($_SESSION['level'] == 'admin') {
                                            ?>
                                                <td class="text-nowrap">
                                                    <a href="proses_peminjaman.php?proses=edit&id=<?= $row['id'] ?>" class="btn btn-warning" data-toggle="modal" data-target="#editBarang<?= $row['id'] ?>"><i class="fas fa-edit"></i></a>
                                                    <a href="proses_peminjaman.php?proses=delete&id=<?= $row['id'] ?>" onclick="return confirm('Apakah yakin hapus data ini?')" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
                <h5 class="modal-title" id="inputBarangLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="proses_peminjaman.php?proses=insert" method="POST">
                    <div class="form-group mt-3 mb-2">
                        <label for="nama">Nama Peminjam :</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="<?= $_SESSION['nama'] ?>" required readonly>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label for="username"><?= $_SESSION['level'] == 'dosen' ? 'NIP' : 'NIM' ?> :</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?= $_SESSION['username']?>" readonly required>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label>Nama Barang</label>
                        <select name="kode_brg" class="custom-select form-control">
                            <option selected>Pilih barang</option>
                            <?php
                            $barangs = $db->query("SELECT * FROM barang");
                            foreach ($barangs as $data) { ?>
                                <option value="<?= $data['kode_brg'] ?>">
                                    <?= $data['kode_brg'] ?> - <?= $data['nama_brg'] ?> - <?= $data['jenis_brg'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label for="tgl_peminjaman">Tanggal Peminjaman :</label>
                        <input type="date" class="form-control" name="tgl_peminjaman" id="tgl_peminjaman">
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label for="qty">Kuantitas Barang :</label>
                        <input type="number" class="form-control" name="qty" id="qty" required>
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

$query = "SELECT * FROM pinjaman 
INNER JOIN barang ON pinjaman.kode_brg = barang.kode_brg 
INNER JOIN user ON pinjaman.nama = user.nama
ORDER BY barang.nama_brg";
$result = $db->query($query);

foreach ($result as $row) :
?>
<div class="modal fade" id="editBarang<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editBarangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBarangLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="proses_peminjaman.php?proses=update" method="POST">
                    <div class="form-group mt-3 mb-2">
                        <label for="nama">Nama Peminjam :</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="<?= $row['nama'] ?>" required readonly>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label for="username"><?= $_SESSION['level'] == 'dosen' ? 'NIP' : 'NIM' ?> :</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?= $row['username'] ?>" required readonly>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label>Nama Barang</label>
                        <input type="text" id="nama" name="nama" class="form-control" value=" <?= $row['kode_brg'] ?> - <?= $row['nama_brg'] ?> - <?= $row['jenis_brg'] ?>" readonly>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label for="tgl_peminjaman">Tanggal Peminjaman :</label>
                        <input type="date" class="form-control" name="tgl_peminjaman" id="tgl_peminjaman" value="<?= $row['tgl_peminjaman']; ?>" readonly>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label for="qty">Kuantitas Barang :</label>
                        <input type="number" class="form-control" name="qty" id="qty" value="<?= $row['qty'] ?>" required>
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
<?php 
endforeach; 
?>

<?php
        break;
}
?>