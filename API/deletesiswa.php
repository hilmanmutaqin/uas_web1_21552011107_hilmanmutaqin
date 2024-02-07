<?php
header("Access-Control-Allow-Origin: *");
include('../koneksi/koneksi.php');

$id = $_POST["idnews"];

try {
    $query = "DELETE FROM tb_siswa WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $pesan = "Data berhasil dihapus";
        echo $pesan;
    } else {
        throw new Exception("Gagal menghapus data");
    }

    $stmt->close();
} catch (Exception $e) {
    die($e->getMessage());
}

$conn->close();
?>
