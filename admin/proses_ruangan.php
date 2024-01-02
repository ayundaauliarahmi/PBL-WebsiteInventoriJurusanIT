<?php
include '../koneksi.php';

if ($_GET['proses'] == 'insert') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_ruangan = $_POST['nama_ruangan'];
        $id_ruangan = $_POST['id_ruangan'];

        $query = "INSERT INTO ruangan (nama_ruangan, id_ruangan) VALUES ( '$nama_ruangan', '$id_ruangan')";
        if ($db->query($query) === TRUE) {
            header("Location: index.php?page=data_ruangan"); //redirect
            exit;
        } else {
            echo "Error: " . $query . "<br>" . $db->error;
        }
    }
}
