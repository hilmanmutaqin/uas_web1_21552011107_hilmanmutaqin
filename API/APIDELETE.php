<?php

include("../koneksi/koneksi.php");

// Fungsi untuk menghapus user berdasarkan user_id
function deleteUser($user_id) {
    global $conn;

    $sql = "DELETE FROM tbl_user WHERE user_id = $user_id";

    if ($conn->query($sql) === TRUE) {
        $response = array("status" => "success", "message" => "User berhasil dihapus");
    } else {
        $response = array("status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error);
    }

    return $response;
}

// Mendapatkan data dari permintaan DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Mendapatkan data JSON dari body permintaan
    $data = json_decode(file_get_contents("php://input"), true);

    // Memastikan user_id yang dibutuhkan tersedia
    if (isset($data['user_id'])) {
        $user_id = $data['user_id'];

        // Menghapus user berdasarkan user_id
        $result = deleteUser($user_id);

        // Memberikan respon JSON
        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        $response = array("status" => "error", "message" => "user_id tidak valid");
        echo json_encode($response);
    }
} else {
    $response = array("status" => "error", "message" => "Metode permintaan tidak valid");
    echo json_encode($response);
}

?>
