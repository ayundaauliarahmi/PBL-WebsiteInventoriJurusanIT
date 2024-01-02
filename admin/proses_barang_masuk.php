<?php
include '../koneksi.php';

if ($_GET['proses'] == 'insert') {
    // query insert
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_brg = $_POST['kode_brg'];
    $tanggal = $_POST['tgl_masuk'];
    $qty = $_POST['qty'];
    $id_ruangan = $_POST['id_ruangan'];
    $penerima = $_POST['penerima'];

    $query = "INSERT INTO brg_masuk (kode_brg, qty, tgl_masuk, id_ruangan, penerima) VALUES ('$kode_brg', '$qty', '$tanggal', '$id_ruangan', '$penerima')";
    if ($db->query($query) === TRUE) {
        // Update stok barang di tabel barang
        $update_query = "UPDATE barang SET stock = stock + '$qty' WHERE kode_brg = '$kode_brg'";
        if ($db->query($update_query) === TRUE) {
            header("Location: index.php?page=barang_masuk");
            exit;
        } else {
            echo "Error updating record: " . $db->error;
        }
    } else {
        echo "Error: " . $query . "<br>" . $db->error;
    }
}
}

if ($_GET['proses'] == 'update') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $qty = $_POST['qty'];
        $penerima = $_POST['penerima'];

        // Ambil data qty awal dari database
        $querySelectOldQty = "SELECT qty, kode_brg FROM brg_masuk WHERE id='$id'";
        $resultOldQty = $db->query($querySelectOldQty);
        $rowOldQty = $resultOldQty->fetch_assoc();
        $oldQty = $rowOldQty['qty'];
        $kode_brg = $rowOldQty['kode_brg'];

        $query = "UPDATE brg_masuk SET qty='$qty', penerima='$penerima' WHERE id='$id'";
        if ($db->query($query) === TRUE) {
            // Hitung selisih antara qty baru dan qty lama
            $qtyDifference = $qty - $oldQty;

            // Update stok barang di tabel barang berdasarkan selisih qty
            $update_query = "UPDATE barang SET stock = stock + '$qtyDifference' WHERE kode_brg = '$kode_brg'";
            if ($db->query($update_query) === TRUE) {
                header("Location: index.php?page=barang_masuk");
                exit;
            } else {
                echo "Error updating record: " . $db->error;
            }
        } else {
            echo "Error: " . $query . "<br>" . $db->error;
        }
    }
}

if ($_GET['proses'] == 'delete') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $id = $_GET['id'];

        // Ambil jumlah qty yang akan dihapus dari brg_masuk
        $queryGetQty = "SELECT qty, kode_brg FROM brg_masuk WHERE id='$id'";
        $resultGetQty = $db->query($queryGetQty);
        $rowGetQty = $resultGetQty->fetch_assoc();
        $qtyToDelete = $rowGetQty['qty'];
        $kode_brg = $rowGetQty['kode_brg'];

        // Hapus data dari brg_masuk
        $queryDeleteBrgMasuk = "DELETE FROM brg_masuk WHERE id='$id'";
        if ($db->query($queryDeleteBrgMasuk) === TRUE) {
            // Kurangi stock di tabel barang
            $update_query = "UPDATE barang SET stock = stock - '$qtyToDelete' WHERE kode_brg = '$kode_brg'";
            if ($db->query($update_query) === TRUE) {
                header("Location: index.php?page=barang_masuk");
                exit;
            } else {
                echo "Error updating record: " . $db->error;
            }
        } else {
            echo "Error deleting record: " . $db->error;
        }
    }
}
