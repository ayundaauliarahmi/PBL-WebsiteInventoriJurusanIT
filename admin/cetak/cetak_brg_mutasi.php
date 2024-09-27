<?php
include '../../koneksi.php';

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Barang Masuk Inventori Jurusan Teknologi Informasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="border: none;">
                        <div class="card-body">
                            <table class="table text-center" style="font-family: 'Times New Roman', Times, serif; border-bottom: 1px solid #000;">
                                <tr>
                                    <td style="width: 25%; max-width: 150px; vertical-align: middle;">
                                        <img src="../../assets/img/pnp.png" class="img-fluid" alt="Logo Pnp">
                                    </td>
                                    <td style="width: 75%;">
                                        <p style="font-size: medium;">
                                            KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, <br>
                                            RISET, DAN TEKNOLOGI <br>
                                            POLITEKNIK NEGERI PADANG <br>
                                            JURUSAN TEKNOLOGI INFORMASI <br>
                                            Kampus Politeknik Negeri Padang, Limau Manis, Padang, Sumatera Barat <br>
                                            Telepon (0751) 725590, Faks. (0751) 72576 <br>
                                            Laman: <a href="https://www.pnp.ac.id">https://www.pnp.ac.id</a>
                                            Surel: info@pnp.ac.id
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <header class="text-center mb-4 fw-bold">
        <h5>DATA BARANG MUTASI</h5>
        <?php

        $bulan = $_POST['bulan'];
        $bln = date("F Y", strtotime($bulan));

        ?><div class="container">
            <p>Bulan = <?= $bln ?></p>
        </div>
    </header>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Mutasi</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jenis</th>
                                    <th>Lokasi Awal</th>
                                    <th>Lokasi Sekarang</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $bulan = $_POST['bulan'];

                                $query = "SELECT * FROM brg_mutasi 
                                INNER JOIN ruangan ON brg_mutasi.id_ruangan = ruangan.id_ruangan 
                                INNER JOIN barang ON brg_mutasi.kode_brg = barang.kode_brg 
                                WHERE DATE_FORMAT(brg_mutasi.tgl_mutasi,'%Y-%m') = '$bulan'
                                ORDER BY brg_mutasi.tgl_mutasi";
                                $result = $db->query($query);

                                $nomor = 1;
                                foreach ($result as $row) :
                                ?>
                                    <tr>
                                        <td class="text-nowrap"><?= $nomor++ ?></td>
                                        <td class="text-nowrap">
                                            <?php $tgl_mutasi = $row['tgl_mutasi'];
                                            echo date("d-M-Y", strtotime($tgl_mutasi)) ?>
                                        </td>
                                        <td class="text-nowrap"><?= $row['kode_brg'] ?></td>
                                        <td class="text-nowrap"><?= $row['nama_brg'] ?></td>
                                        <td class="text-nowrap"><?= $row['jenis_brg'] ?></td>
                                        <td class="text-nowrap"><?= $row['ruangan'] ?></td>
                                        <td class="text-nowrap"><?= $row['nama_ruangan'] ?></td>
                                        <td class="text-nowrap"><?= $row['qty'] ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.col -->
            </div>
        </div>
    </section>

    <section class="content m-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <table style="width: 100%;text-align: right; margin-right: 10rem;">
                        <tbody>
                            <tr>
                                <td> , <?php echo date('d F Y'); ?></td>
                            </tr>
                            <tr>
                                <td><br><br><br></td> <!-- Untuk kolom kosong atau tanda tangan -->
                            </tr>
                            <tr>
                                <td>Kepala Labor Teknologi Informasi</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
        </div>
    </section>

    <!--MyJavaScript-->
    <script>
        window.print()
    </script>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>