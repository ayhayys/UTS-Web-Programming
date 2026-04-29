<?php
require 'koneksi.php';
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

$stmtGet = $conn->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmtGet->bind_param("i", $id);
$stmtGet->execute();
$foto = $stmtGet->get_result()->fetch_assoc()['foto'] ?? '';

$stmt = $conn->prepare("DELETE FROM penulis WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    if ($foto != 'default.png' && file_exists('uploads_penulis/' . $foto)) {
        unlink('uploads_penulis/' . $foto);
    }
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Penulis tidak bisa dihapus karena masih memiliki artikel.']);
}
?>