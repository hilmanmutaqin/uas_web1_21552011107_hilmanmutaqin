<?php 
header("Access-Control-Allow-Origin: *");
include ("../koneksi/koneksi.php");

$username = $_POST["inputEmail"];
$password = $_POST["inputPassword"];

if (isset($username) && isset($password)){

    //Mengambil data pengguna dari database berdasarkan username
    $statement = $conn->prepare("SELECT id, username, password FROM user WHERE username = ?");
    $statement->bind_param("s", $username); 
    $statement->execute(); 
    $result = $statement->get_result();
    $user = $result->fetch_assoc();

    //Verifikasi kata sandi dengan menggnakan SHA1
    if ($user && sha1($password) === $user['password']) {
        //ika verifikasi berhasil, buat token sesi baru 
        $session_token = bin2hex(random_bytes(16));

        //perbarui token sesi di database
        $updateStatement = $conn->prepare("UPDATE user SET session_token = ? WHERE id = ?");
        $updateStatement->bind_param("si", $session_token, $user['id']);
        $updateStatement->execute(); 
        //Mengembalikan respon JSON sukses dengan tokenn sesi
        echo json_encode(['status' => 'success', 'session_token' => $session_token]);
    } else {
        // Jika verifikasi gagal, kirim pesan kesalahan
        echo json_encode(['status' => 'error', 'message' => 'Kredensial tidak valid']);
    }
}else{
    // Jika permintaan tidak valid, kirim pesan kesalah 
    echo json_encode(['status' => 'error', 'message' => 'Permintaan tidak valid']);
    
}
?>