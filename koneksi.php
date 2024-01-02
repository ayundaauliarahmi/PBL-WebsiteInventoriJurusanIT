<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "db_inventory";

$db = new mysqli($host,$username,$password,$database);

if ($db->connect_error) {
    die("Koneksi gagal! " . $db->connect_error);
}

?>