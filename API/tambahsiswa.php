<?php
header("Access-Control-Allow-Origin: *");
header("Cache-Control: no-cache, no-store, max-age=0, must-revalidate");
header("X-Content-Type-Options: nosniff"); 

include ("../koneksi/koneksi.php");

if(isset($_POST["nis"], $_POST["nama"], $_POST["tanggal"], $_FILES['url_image'])) {
    $nis = $_POST["nis"];
    $nama = $_POST["nama"];
    $date = $_POST["tanggal"];
    $namafile = $_FILES['url_image']['name'];
    $tmp_name = $_FILES['url_image']['tmp_name'];

    // Check if the 'archive' directory exists, create it if not
    if (!is_dir('archive')) {
        mkdir('archive', 0755, true);
    }

    try {
        move_uploaded_file($tmp_name, 'archive/'.$namafile);
        
        $statement = $conn->prepare("INSERT INTO tb_siswa (id, nis, nama, img, date) VALUES (NULL,?,?,?,?)");
        $statement->execute([$nis, $nama, 'archive/' . $namafile, $date]);
        
        $pesan = "Data siswa berhasil ditambah";
        echo $pesan;
    } catch (PDOException $e) {
        // This will catch any PDOExceptions
        echo "Database error: " . $e->getMessage();
    } catch (Exception $e) {
        // This will catch any general exceptions
        echo "General error: " . $e->getMessage();
    }
} else {
    echo "Invalid request. Please make sure all required fields are filled.";
}
?>
