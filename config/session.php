<?php
header("Access-Control-Allow-Origin: *");
include("../koneksi/koneksi.php");

$session_token = $_POST['session_token'];

if (isset($session_token)) {
    // Mengambil data pengguna dari database berdasarkan session_token
    $statement = $conn->prepare("SELECT name FROM user WHERE session_token = ?");
    $statement->bind_param("s", $session_token); 
    $statement->execute();
    $statement->store_result();

    if ($statement->num_rows > 0) {
        $statement->bind_result($name);
        $statement->fetch();

        echo json_encode(['status' => 'success', 'hasil' => ['name' => $name]]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Sesi tidak valid']);
    }

    $statement->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Permintaan tidak valid']);
}
?>
