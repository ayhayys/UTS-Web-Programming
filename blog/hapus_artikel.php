<?php
require 'koneksi.php';
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

$stmtGet = $conn->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmtGet->bind_param("i", $id);
$stmtGet->execute();
$gambar = $stmtGet->get_result()->fetch_assoc()['gambar'] ?? '';

$stmt = $conn->prepare("DELETE FROM artikel WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    if (file_exists('uploads_artikel/' . $gambar)) unlink('uploads_artikel/' . $gambar);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>