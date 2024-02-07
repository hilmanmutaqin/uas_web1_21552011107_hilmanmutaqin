<?php

$database_hostname = "localhost";
$database_user = "id21715312_hilmanmutaqin";
$database_password = "Clashofclans123#";
$database_name = "id21715312_web1";


$conn = mysqli_connect($database_hostname, $database_user, $database_password, $database_name);

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
} else {
    // echo "koneksi berhasil"; 
}
?>
