<?php
include '../koneksi.php';

if ($_GET['proses'] == 'insert') {
    // query insert

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$kode_brg = $_POST['kode_brg'];
$nama_brg = $_POST['nama_brg'];
$jenis_brg = $_POST['jenis_brg'];
$kategori = $_POST['kategori'];
$satuan = $_POST['satuan'];
$stock = $_POST['stock'];

$query = "INSERT INTO barang (kode_brg, nama_brg, jenis_brg, kategori, satuan, stock) VALUES ('$kode_brg', '$nama_brg', '$jenis_brg', '$kategori', '$satuan', '$stock')";
if ($db->query($query) === TRUE) {
    header("Location: index.php?page=data_barang"); //redirect
    exit;
} else {
    echo "Error: " . $query . "<br>" . $db->error;
}
}  
}

if ($_GET['proses'] == 'update') {
// query update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_brg = $_POST['kode_brg'];
    $nama_brg = $_POST['nama_brg'];
    $jenis_brg = $_POST['jenis_brg'];
    $kategori = $_POST['kategori'];
    $satuan = $_POST['satuan'];
    $stock = $_POST['stock'];

    $query = "UPDATE barang SET kode_brg='$kode_brg',nama_brg='$nama_brg', jenis_brg='$jenis_brg', kategori='$kategori', satuan='$satuan', stock='$stock' WHERE kode_brg='$kode_brg'";
    if ($db->query($query) === TRUE) {
        header("Location: index.php?page=data_barang"); //redirect
        exit;
    } else {
        echo "Error: " . $query . "<br>" . $db->error;
    }
}

}

if ($_GET['proses'] == 'delete') {
    // query delete
    
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $kode_brg = $_GET['kode_brg'];

    // Hapus data dashboard berdasarkan kode_brg
    $query = "DELETE FROM barang WHERE kode_brg='$kode_brg'";
    if ($db->query($query) === TRUE) {
        header("Location: index.php?page=data_barang");
        exit;
    } else {
        echo "Error: " . $query . "<br>" . $db->error;
    }
}
}