<?php
header("Access-Control-Allow-Origin: *");

// Include file koneksi
include ('../koneksi/koneksi.php');

$session_token = $_POST['session_token'];

if (isset($session_token)) {
    $session_token = $session_token;

    // Prepare statement untuk update session token
    $updateStatement = $conn->prepare("UPDATE user SET session_token = NULL WHERE session_token = ?");
    $updateStatement->bind_param("s", $session_token);
    $updateStatement->execute();

    // Periksa jumlah baris yang terpengaruh oleh operasi update
    $affectedRows = $updateStatement->affected_rows;

    if ($affectedRows > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Logout berhasil']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Token tidak valid']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

// Tutup statement dan koneksi setelah selesai menggunakan
$updateStatement->close();
$conn->close();
?>
