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
                        <h1 class="m-3">Data Ruangan</h1>
                    </div><!-- /.col -->
                    <?php
                    if ($_SESSION['level'] == 'admin') {
                    ?>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php?page=data_ruangan" class="btn btn-primary m-3 fa-plus" data-toggle="modal" data-target="#inputRuang"> Tambah Ruangan</a></li>
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
                                                <th>ID Ruangan</th>
                                                <th>Nama Ruangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <?php
                                                $query = "SELECT * FROM ruangan ORDER BY id_ruangan";
                                                $result = $db->query($query);

                                                $nomor = 1;
                                                foreach ($result as $row) :
                                                ?>
                                                    <td class="text-nowrap"><?= $nomor++ ?></td>
                                                    <td class="text-nowrap"><?= $row['id_ruangan'] ?></td>
                                                    <td class="text-nowrap"><?= $row['nama_ruangan'] ?></td>
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
        <div class="modal fade" id="inputRuang" tabindex="-1" role="dialog" aria-labelledby="inputBarangLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inputBarangLabel">Input Ruangan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="proses_ruangan.php?proses=insert" method="POST">
                            <div class="form-group mt-3 mb-2">
                                <label for="id_ruangan">ID Ruangan :</label>
                                <input type="text" class="form-control" name="id_ruangan" id="id_ruangan" required>
                            </div>
                            <div class="form-group mt-3 mb-2">
                                <label for="nama_ruangan">Nama Ruangan :</label>
                                <input type="text" class="form-control" name="nama_ruangan" id="nama_ruangan" required>
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
<?php
        break;
}
?>