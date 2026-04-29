<?php
require 'koneksi.php';
$query = "SELECT a.id, a.judul, a.gambar, a.hari_tanggal, k.nama_kategori, p.nama_depan, p.nama_belakang 
          FROM artikel a 
          JOIN kategori_artikel k ON a.id_kategori = k.id 
          JOIN penulis p ON a.id_penulis = p.id ORDER BY a.id DESC";
$result = $conn->query($query);
$data = [];
while ($row = $result->fetch_assoc()) {
    $row['judul'] = htmlspecialchars($row['judul'], ENT_QUOTES, 'UTF-8');
    $data[] = $row;
}
echo json_encode($data);
?>