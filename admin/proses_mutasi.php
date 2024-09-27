<?php
include '../koneksi.php';

if ($_GET['proses'] == 'insert') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $kode_brg = $_POST['kode_brg'];
        $tgl_mutasi = $_POST['tgl_mutasi'];
        $id_ruangan = $_POST['id_ruangan'];
        $ruangan = $_POST['ruangan'];
        $qty = $_POST['qty'];

        // Mengambil stok saat ini dari barang
        $getStockQuery = "SELECT stock FROM barang WHERE kode_brg = '$kode_brg'";
        $stockResult = $db->query($getStockQuery);
        $row = $stockResult->fetch_assoc();
        $currentStock = $row['stock'];

        if ($currentStock >= $qty) {
            //Jika stok mencukupi maka lakukan mutasi barang
            $query = "INSERT INTO brg_mutasi (kode_brg, tgl_mutasi, ruangan, id_ruangan, qty) VALUES ('$kode_brg', '$tgl_mutasi', '$ruangan', '$id_ruangan', '$qty')";

            if ($db->query($query) === TRUE) {
                // Update stok barang di tabel barang
                $update_query = "UPDATE barang SET stock = stock - '$qty' WHERE kode_brg = '$kode_brg'";
                if ($db->query($update_query) === TRUE) {
                    header("Location: index.php?page=mutasi_barang");
                    exit;
                } else {
                    echo "Error updating record: " . $db->error;
                }
            } else {
                echo "Error: " . $query . "<br>" . $db->error;
            }
        } else {
            // Tampilkan alert jika stok tidak mencukupi
            echo "<script>alert('Stok barang tidak mencukupi untuk melakukan mutasi barang!');window.history.back();</script>";
        }
    }
}

if ($_GET['proses'] == 'update') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_mutasi = $_POST['id_mutasi'];
        $tgl_mutasi = $_POST['tgl_mutasi'];
        $id_ruangan = $_POST['id_ruangan'];
        $qty = $_POST['qty'];

        // Periksa data lama qty dari database
        $querySelectOldQty = "SELECT qty, kode_brg FROM brg_mutasi WHERE id_mutasi = '$id_mutasi'";
        $resultOldQty = $db->query($querySelectOldQty);
        
        if ($resultOldQty) {
            $rowOldQty = $resultOldQty->fetch_assoc();
            $oldQty = $rowOldQty['qty'];
            $kode_brg = $rowOldQty['kode_brg'];

            // Mengambil stok saat ini dari barang
            $getStockQuery = "SELECT stock FROM barang WHERE kode_brg = '$kode_brg'";
            $stockResult = $db->query($getStockQuery);

            if ($stockResult) {
                $row = $stockResult->fetch_assoc();
                $currentStock = $row['stock'];

                // Hitung Selisih Antara qty baru dan lama
                $qtyDifference = $qty - $oldQty;

                // Jika Stok mencukupi untuk mengkompensasi perubahan qty
                if ($currentStock >= $qtyDifference) {
                    // Lakukan update pada tabel brg_mutasi
                    $query = "UPDATE brg_mutasi SET tgl_mutasi='$tgl_mutasi', id_ruangan='$id_ruangan', qty='$qty' WHERE id_mutasi='$id_mutasi'";

                    if ($db->query($query) === TRUE) {
                        // Update stok barang di tabel barang berdasarkan selisih qty
                        $update_query = "UPDATE barang SET stock = stock - '$qtyDifference' WHERE kode_brg = '$kode_brg'";
                        if ($db->query($update_query) === TRUE) {
                            header("Location: index.php?page=mutasi_barang");
                            exit;
                        } else {
                            echo "Error updating record: " . $db->error;
                        }
                    } else {
                        echo "Error: " . $query . "<br>" . $db->error;
                    }
                } else {
                    // Tampilkan Allert jika stok tidak cukup
                    echo "<script>alert('Stok barang tidak mencukupi untuk melakukan mutasi barang!');window.history.back();</script>";
                }
            } else {
                echo "Error fetching stock: " . $db->error;
            }
        } else {
            echo "Error fetching old quantity: " . $db->error;
        }
    }
}


if ($_GET['proses'] == 'delete') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $id_mutasi = $_GET['id_mutasi'];

        // Ambil jumlah qty yang akan dihapus dari brg_mutasi
        $queryGetQty = "SELECT qty, kode_brg FROM brg_mutasi WHERE id_mutasi='$id_mutasi'";
        $resultGetQty = $db->query($queryGetQty);
        $rowGetQty = $resultGetQty->fetch_assoc();
        $qtyToDelete = $rowGetQty['qty'];
        $kode_brg = $rowGetQty['kode_brg'];

        // Hapus data dari brg_mutasi
        $queryDeleteBrgMasuk = "DELETE FROM brg_mutasi WHERE id_mutasi='$id_mutasi'";
        if ($db->query($queryDeleteBrgMasuk) === TRUE) {
            // Kurangi stock di tabel barang hanya jika data brg_mutasi berhasil dihapus
            $update_query = "UPDATE barang SET stock = stock + '$qtyToDelete' WHERE kode_brg = '$kode_brg'";
            if ($db->query($update_query) === TRUE) {
                header("Location: index.php?page=mutasi_barang");
                exit;
            } else {
                echo "Error updating record: " . $db->error;
            }
        } else {
            echo "Error deleting record: " . $db->error;
        }
    }
}
