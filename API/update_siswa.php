<?php
header("Access-Control-Allow-Origin: *");
include('../koneksi/koneksi.php');

$id = $_POST["id"];
$nis = $_POST["nis"];
$nama = $_POST["nama"];

// Periksa apakah file gambar dikirimkan
if (isset($_FILES['url_image']) && $_FILES['url_image']['error'] === UPLOAD_ERR_OK) {
    // File gambar dikirimkan, tangani unggahan
    $namafile = $_FILES['url_image']['name'];
    $tmp_name = $_FILES['url_image']['tmp_name'];
    $upload_directory = 'archive/';

    // Pindahkan file ke direktori yang ditentukan
    move_uploaded_file($tmp_name, $upload_directory . $namafile);

    // Update data dengan file gambar
    $statement = $conn->prepare("UPDATE `tb_siswa` SET `nis`=?, `nama`=?, `img`=? WHERE `id`=?");
    $statement->execute([$nis, $nama, $upload_directory . $namafile, $id]);
} else {
    // File gambar tidak dikirimkan, tangani tanpa file gambar
    $statement = $conn->prepare("UPDATE `tb_siswa` SET `nis`=?, `nama`=? WHERE `id`=?");
    $statement->execute([$nis, $nama, $id]);
}

$message = "Data berhasil diubah";
echo $message;
?>
