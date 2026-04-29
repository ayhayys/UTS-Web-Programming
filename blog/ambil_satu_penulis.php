<?php
require 'koneksi.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $conn->prepare("SELECT id, nama_depan, nama_belakang, user_name, foto FROM penulis WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
echo json_encode($stmt->get_result()->fetch_assoc());
?>