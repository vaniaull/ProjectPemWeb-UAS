<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'coffee_shop';

$conn = new mysqli($host, $user, $pass, $dbname);

// Set charset biar aman pakai UTF-8 (hindari karakter aneh di DB)
$conn->set_charset("utf8mb4");

// Cek koneksi
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Koneksi gagal: " . $conn->connect_error]);
    exit;
}
?>
