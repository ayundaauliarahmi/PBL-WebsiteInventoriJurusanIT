<?php
include '../koneksi.php';

if ($_GET['proses'] == 'insert') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $tgl_peminjaman = $_POST['tgl_peminjaman'];
        $tgl_kembali = date("Y-m-d", strtotime("$tgl_peminjaman +1 day"));
        $kode_brg = $_POST['kode_brg'];
        $qty = $_POST['qty'];

        $query = "INSERT INTO pinjaman (nama, username, tgl_peminjaman, tgl_kembali, kode_brg, qty) 
                  VALUES ('$nama', '$username', '$tgl_peminjaman', '$tgl_kembali', '$kode_brg', '$qty')";

        if ($db->query($query) === TRUE) {
            $data = $db->query("SELECT * FROM barang WHERE kode_brg = '$kode_brg'");
            foreach($data as $item){
                $stock = $item['stock'] - $qty;
                $db->query("UPDATE barang SET
                        stock = '$stock'
                        WHERE kode_brg = '$kode_brg'
                ");
            }
            header("Location: index.php?page=peminjaman");
            exit;
        } else {
            echo "Error: " . $query . "<br>" . $db->error;
        }
    }
}

if ($_GET['proses'] == 'update') {
// query update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'];
    $qty = $_POST['qty'];
   
    $query = "UPDATE pinjaman SET qty='$qty' WHERE id='$id'";
    if ($db->query($query) === TRUE) {
        header("Location: index.php?page=peminjaman"); //redirect
        exit;
    } else {
        echo "Error: " . $query . "<br>" . $db->error;
    }
}

}

if ($_GET['proses'] == 'delete') {
    // query delete
    
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];

    // Hapus data peminjaman berdasarkan id
    $query = "DELETE FROM pinjaman WHERE id='$id'";
    if ($db->query($query) === TRUE) {
        header("Location: index.php?page=peminjaman");
        exit;
    } else {
        echo "Error: " . $query . "<br>" . $db->error;
    }
}
}