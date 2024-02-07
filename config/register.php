<?php
// Include file koneksi
include ('../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST["username"];
    $name = $_POST["name"];
    $password = $_POST["password"];

    $hashedPassword = sha1($password);

    if (!$conn) {
        die("Koneksi Gagal: " . mysqli_connect_error());
    }

    try {
        // Check if the username already exists
        $checkQuery = "SELECT id FROM user WHERE username = '$username'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (!$checkResult) {
            throw new Exception("Error: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($checkResult) > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Username already exists']);
        } else {
            // Insert the new user
            $insertQuery = "INSERT INTO user (username, name, password, session_token) VALUES ('$username', '$name', '$hashedPassword', '')";
            $insertResult = mysqli_query($conn, $insertQuery);

            if (!$insertResult) {
                throw new Exception("Error: " . mysqli_error($conn));
            }

            echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }

    // Tutup koneksi MySQLi setelah selesai menggunakan
    mysqli_close($conn);

    exit();
}
?>
