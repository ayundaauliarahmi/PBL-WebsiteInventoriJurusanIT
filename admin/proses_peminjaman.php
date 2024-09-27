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

        //Cek status pengembalian
        $check = $db->query("SELECT * FROM pinjaman WHERE nama = '$nama' AND status is NULL");

        if ($check->num_rows > 0) {
            echo "<script>alert('Anda masih memiliki barang yang belum dikembalikan!');window.history.back();</script>";
        } else {
            // Query untuk memeriksa stok barang
            $check_stock = $db->query("SELECT stock FROM barang WHERE kode_brg = '$kode_brg'");
            $stock_data = $check_stock->fetch_assoc();
            $current_stock = $stock_data['stock'];

            // Cek apakah stok cukup untuk peminjaman
            if ($current_stock >= $qty && $qty == 1) {
                $query = "INSERT INTO pinjaman (nama, username, tgl_peminjaman, tgl_kembali, kode_brg, qty) 
                          VALUES ('$nama', '$username', '$tgl_peminjaman', '$tgl_kembali', '$kode_brg', '$qty')";

                if ($db->query($query) === TRUE) {
                    $new_stock = $current_stock - $qty;
                    // Update stok barang setelah peminjaman
                    $update_stock = $db->query("UPDATE barang SET stock = '$new_stock' WHERE kode_brg = '$kode_brg'");
                    if ($update_stock) {
                        header("Location: index.php?page=peminjaman");
                        exit;
                    } else {
                        echo "Error updating stock!";
                    }
                } else {
                    echo "Error: " . $query . "<br>" . $db->error;
                }
            } else {
                // Tampilkan alert jika stok tidak mencukupi
                echo "<script>alert('Stok barang tidak mencukupi untuk melakukan peminjaman atau stock barang yang dipinjam lebih!');window.history.back();</script>";
            }
        }
    }
}

if ($_GET['proses'] == 'update') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $kode_brg = $_POST['kode_brg'];

        $query = "UPDATE pinjaman SET kode_brg = '$kode_brg' WHERE id = $id";

        if ($db->query($query) === TRUE) {
            // Redirect atau sesuaikan dengan kebutuhan setelah update
            header("Location: index.php?page=peminjaman");
            exit;
        } else {
            echo "Error updating record: " . $db->error;
        }
    }
}


// if ($_GET['proses'] == 'update') {
//     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//         $id = $_POST['id'];
//         $kode_brg = $_POST['kode_brg'];

//         // Ambil data peminjaman yang akan diubah
//         $getData = $db->query("SELECT * FROM pinjaman WHERE id = '$id'");
//         if ($getData) {
//             $rowData = $getData->fetch_assoc();
//             $currentQty = $rowData['qty']; // Ambil kuantitas sebelumnya
//             $kode_brg = $rowData['kode_brg']; // Ambil kode barang dari data peminjaman

//             // Mengambil stok saat ini dari barang
//             $getStockQuery = $db->query("SELECT stock FROM barang WHERE kode_brg = '$kode_brg'");
//             if ($getStockQuery) {
//                 $row = $getStockQuery->fetch_assoc();
//                 $currentStock = $row['stock'];

//                 // Hitung selisih antara qty baru dan lama
//                 $qtyDifference = $currentQty - $qty;

//                 // Jika stok mencukupi untuk mengkompensasi perubahan qty
//                 if ($currentStock <= $qtyDifference) {
//                     // Update kuantitas peminjaman
//                     $query = "UPDATE pinjaman SET qty='$qty' WHERE id='$id'";
//                     if ($db->query($query) === TRUE) {
//                         // Update stok barang
//                         $newStock = $currentStock + $qtyDifference;
//                         $updateStockQuery = "UPDATE barang SET stock='$newStock' WHERE kode_brg='$kode_brg'";
//                         if ($db->query($updateStockQuery) === TRUE) {
//                             header("Location: index.php?page=peminjaman"); // Redirect ke halaman peminjaman
//                             exit;
//                         } else {
//                             echo "Error updating stock: " . $db->error;
//                         }
//                     } else {
//                         echo "Error updating quantity: " . $db->error;
//                     }
//                 } else {
//                     echo "<script>alert('Stok barang tidak mencukupi untuk melakukan peminjaman!');window.history.back();</script>";
//                 }
//             } else {
//                 echo "Error fetching current stock: " . $db->error;
//             }
//         } else {
//             echo "Error fetching data: " . $db->error;
//         }
//     }
// }

if ($_GET['proses'] == 'delete') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $id = $_GET['id'];

        // Ambil jumlah qty yang akan dihapus dari pinjaman
        $queryGetQty = "SELECT qty, kode_brg FROM pinjaman WHERE id='$id'";
        $resultGetQty = $db->query($queryGetQty);
        $rowGetQty = $resultGetQty->fetch_assoc();
        $qtyToDelete = $rowGetQty['qty'];
        $kode_brg = $rowGetQty['kode_brg'];

        // Hapus data dari pinjaman
        $queryDeleteBrgMasuk = "DELETE FROM pinjaman WHERE id='$id'";
        if ($db->query($queryDeleteBrgMasuk) === TRUE) {
            // Kurangi stock di tabel barang hanya jika data pinjaman berhasil dihapus
            $update_query = "UPDATE barang SET stock = stock + '$qtyToDelete' WHERE kode_brg = '$kode_brg'";
            if ($db->query($update_query) === TRUE) {
                header("Location: index.php?page=peminjaman");
                exit;
            } else {
                echo "Error updating record: " . $db->error;
            }
        } else {
            echo "Error deleting record: " . $db->error;
        }
    }
}
