<?php
require 'koneksi.php';
$result = $conn->query("SELECT * FROM kategori_artikel ORDER BY id DESC");
$data = [];
while ($row = $result->fetch_assoc()) {
    $row['nama_kategori'] = htmlspecialchars($row['nama_kategori'], ENT_QUOTES, 'UTF-8');
    $row['keterangan'] = htmlspecialchars($row['keterangan'], ENT_QUOTES, 'UTF-8');
    $data[] = $row;
}
echo json_encode($data);
?>