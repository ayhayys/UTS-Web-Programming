<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "db_blog";

$conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die(json_encode(['status' => 'error', 'pesan' => 'Koneksi gagal: ' . $conn->connect_error]));
    }
?>