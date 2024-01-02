<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari inputan form yang disimpan secara tersembunyi
    $id = $_POST['id'];
    $kd_barang = $_POST['kd'];

    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d'); 

    // Prepare statement untuk update pinjaman
    $update_pinjaman = $db->prepare("UPDATE pinjaman SET tgl_dikembalikan = ?, status = 'Dikembalikan' WHERE id = ?");
    $update_pinjaman->bind_param("si", $now, $id);
    $update_pinjaman->execute();
    $update_pinjaman->close();

    // Mengambil data jumlah pinjam
    $statement = $db->prepare("SELECT qty FROM pinjaman WHERE id = ?");
    $statement->bind_param("i", $id);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    $jlmh_pinjam = $row['qty'];
    $statement->close();

    // Mengupdate stok barang
    $update_stok = $db->prepare("UPDATE barang SET stock = stock + ? WHERE kode_brg = ?");
    $update_stok->bind_param("is", $jlmh_pinjam, $kd_barang);
    $update_stok->execute();
    $update_stok->close();

    // Redirect setelah selesai update
    header('Location: index.php?page=pengembalian_barang');
    exit;
}
