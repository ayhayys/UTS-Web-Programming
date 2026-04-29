<?php
require 'koneksi.php';
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$stmt = $conn->prepare("DELETE FROM kategori_artikel WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal dihapus (Mungkin kategori ini masih memiliki artikel)']);
}
?>