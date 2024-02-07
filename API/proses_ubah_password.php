<?php
// Include file koneksi
include ('../koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari body permintaan POST
    $sessionToken = $_POST["session_token"];
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];

    if (!$conn) {
        die("Koneksi Gagal: " . mysqli_connect_error());
    }

    try {
        // Mendapatkan username dari session_token
        $query = "SELECT username FROM user WHERE session_token = '$sessionToken'";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            throw new Exception("Error: " . mysqli_error($conn));
        }

        // Memeriksa apakah session_token valid
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $username = $row["username"];

            // Mengambil password saat ini dari database
            $query = "SELECT password FROM user WHERE username = '$username'";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                throw new Exception("Error: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $currentHashedPassword = $row["password"];

                // Memeriksa apakah password saat ini sesuai
                if ($currentHashedPassword !== sha1($currentPassword)) {
                    echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect']);
                } else {
                    // Hashing password baru
                    $hashedNewPassword = sha1($newPassword);

                    // Mengupdate password baru
                    $updateQuery = "UPDATE user SET password = '$hashedNewPassword' WHERE username = '$username'";
                    $updateResult = mysqli_query($conn, $updateQuery);

                    if (!$updateResult) {
                        throw new Exception("Error: " . mysqli_error($conn));
                    }

                    echo json_encode(['status' => 'success', 'message' => 'Password updated successfully']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'User not found']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid session token']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }

    mysqli_close($conn);

    exit();
}
?>
