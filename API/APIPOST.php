<?php

include("../koneksi/koneksi.php");

// Fungsi untuk menambahkan user ke database
function addUser($nis, $nama, $email, $password) {
    global $conn;

    $sql = "INSERT INTO tbl_user (nis, nama, email, password) VALUES ('$nis', '$nama', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        $response = array("status" => "success", "message" => "User berhasil ditambahkan");
    } else {
        $response = array("status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error);
    }

    return $response;
}

// Mendapatkan data dari permintaan POST
$data = json_decode(file_get_contents("php://input"));

// Memastikan data yang dibutuhkan tersedia
if (isset($data->nis) && isset($data->nama) && isset($data->email) && isset($data->password)) {
    $nis = $data->nis;
    $nama = $data->nama;
    $email = $data->email;
    $password = $data->password;

    // Menambahkan user ke database
    $result = addUser($nis, $nama, $email, $password);

    // Memberikan respon JSON
    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    $response = array("status" => "error", "message" => "Data tidak lengkap");
    echo json_encode($response);
}

?>
