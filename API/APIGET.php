<?php

include("../koneksi/koneksi.php");

// Fungsi untuk mendapatkan semua data user dari database
function getUsers() {
    global $conn;

    $sql = "SELECT * FROM tbl_user";
    $result = $conn->query($sql);

    $users = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = array(
                "user_id" => $row["user_id"],
                "nis" => $row["nis"],
                "nama" => $row["nama"],
                "email" => $row["email"]
            );
        }
    }

    return $users;
}

// Mendapatkan data dari permintaan GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Mendapatkan semua data user
    $users = getUsers();

    // Memberikan respon JSON
    header('Content-Type: application/json');
    echo json_encode($users);
} else {
    $response = array("status" => "error", "message" => "Metode permintaan tidak valid");
    echo json_encode($response);
}

?>
