<?php
header("Access-Control-Allow-Origin: *");
include('../koneksi/koneksi.php');

function getProtocol()
{
    $protocol = isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    return $protocol . "://" . $_SERVER['HTTP_HOST'];
}

$keyword = isset($_GET["key"]) ? '%' . $_GET["key"] . '%' : '';

$statement = $conn->prepare("SELECT * FROM tb_siswa WHERE nis LIKE ?");
$statement->bind_param("s", $keyword);
$statement->execute();

$result = $statement->get_result();

$data = array();
while ($row = $result->fetch_assoc()) {
    $row["img"] = getProtocol() . "/API/" . $row["img"];
    $data[] = $row;
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
?>