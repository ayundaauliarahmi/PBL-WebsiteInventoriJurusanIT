<?php
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
case 'list':
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-3">Data Pengembalian Barang</h1>
            </div>
        </div>
    </div>
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
                                        <th>NIM/NIP</th>
                                        <th>Nama Barang</th>
                                        <?php if ($_SESSION['level'] == 'admin') { ?>
                                            <th>Jenis</th>
                                            <th>Tanggal Peminjaman</th>
                                        <?php } ?>
                                        <th>Tanggal Dikembalikan</th>
                                        <th>Stock</th>
                                        <th>Status</th>
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
                                            <td><?= $nomor++ ?></td>
                                            <td><?= $row['nama'] ?></td>
                                            <td><?= $row['username'] ?></td>
                                            <td><?= $row['nama_brg'] ?></td>
                                            <?php if ($_SESSION['level'] == 'admin') { ?>
                                                <td><?= $row['jenis_brg'] ?></td>
                                                <td><?= date("d-M-Y", strtotime($row['tgl_peminjaman'])); ?></td>
                                            <?php } ?>
                                            <td><?= $row['tgl_dikembalikan'] == null ? '-' : date("d-M-Y", strtotime($row['tgl_dikembalikan'])); ?></td>
                                            <td><?= $row['qty'] ?></td>
                                            <td>
                                                <?php if ($row['status'] == null) { ?>
                                                    <?php if ($_SESSION['level'] == 'mahasiswa' || $_SESSION['level'] == 'dosen') { ?>
                                                        <div class="form-button-action">
                                                        <button type="button" class="btn btn-danger">Belum Dikembalikan</button>
                                                    </div>
                                                    <?php } else { ?>
                                                        <div class="form-button-action">
                                                            <form action="proses_pengembalian.php" method="post" onclick="return confirm('Apakah anda yakin sudah dikembalikan?');">
                                                                <!-- Hidden input untuk menyimpan nilai id -->
                                                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                                <input type="hidden" name="kd" value="<?= $row['kode_brg'] ?>">
                                                                <button type="submit" class="btn btn-warning">Kembalikan</button>
                                                            </form>
                                                        </div>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <div class="form-button-action">
                                                        <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#inputBarang<?= $row['id'] ?>">Dikembalikan</button>
                                                    </div>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Detail Peminjaman Barang -->
<?php
$query = "SELECT * FROM pinjaman 
            INNER JOIN barang ON pinjaman.kode_brg = barang.kode_brg 
            INNER JOIN user ON pinjaman.nama = user.nama
            ORDER BY barang.nama_brg";
$result = $db->query($query);

foreach ($result as $row) :
?>
    <div class="modal fade" id="inputBarang<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="inputBarangLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputBarangLabel">Detail Peminjaman Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mt-3 mb-2">
                        <label for="nama">Nama Peminjam :</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="<?= $row['nama'] ?>" readonly>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label for="username"><?= $_SESSION['level'] == 'dosen' ? 'NIP' : 'NIM' ?> :</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?= $row['username'] ?>" readonly>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label>Nama Barang</label>
                        <input type="text" id="kode_brg" name="kode_brg" class="form-control" value="<?= $row['kode_brg'] ?> - <?= $row['nama_brg'] ?> - <?= $row['jenis_brg'] ?>" readonly>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label for="tgl_peminjaman">Tanggal Peminjaman :</label>
                        <input type="date" class="form-control" name="tgl_peminjaman" id="tgl_peminjaman" value="<?= $row['tgl_peminjaman']; ?>" readonly>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label for="tgl_dikembalikan">Tanggal Dikembalikan :</label>
                        <input type="date" class="form-control" name="tgl_dikembalikan" id="tgl_dikembalikan" value="<?= $row['tgl_dikembalikan']; ?>" readonly>
                    </div>
                    <div class="form-group mt-3 mb-2">
                        <label for="qty">Stock :</label>
                        <input type="text" class="form-control" name="qty" id="qty" value="<?= $row['qty'] ?>" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary mt-2" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- End Modal Detail Peminjaman Barang -->

<?php
break;
}
?>
