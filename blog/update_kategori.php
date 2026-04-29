<?php
require 'koneksi.php';
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$nama = $_POST['nama_kategori'] ?? '';
$ket = $_POST['keterangan'] ?? '';

$stmt = $conn->prepare("UPDATE kategori_artikel SET nama_kategori = ?, keterangan = ? WHERE id = ?");
$stmt->bind_param("ssi", $nama, $ket, $id);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'pesan' => 'Kategori diperbarui']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal: ' . $stmt->error]);
}
?>