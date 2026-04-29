<?php
require 'koneksi.php';
$result = $conn->query("SELECT id, nama_depan, nama_belakang, user_name, password, foto FROM penulis ORDER BY id DESC");
$data = [];
while ($row = $result->fetch_assoc()) {
    $row['nama_depan'] = htmlspecialchars($row['nama_depan'], ENT_QUOTES, 'UTF-8');
    $row['nama_belakang'] = htmlspecialchars($row['nama_belakang'], ENT_QUOTES, 'UTF-8');
    $row['user_name'] = htmlspecialchars($row['user_name'], ENT_QUOTES, 'UTF-8');
    $data[] = $row;
}
echo json_encode($data);
?>