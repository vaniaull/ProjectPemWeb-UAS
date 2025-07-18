<?php
$conn = mysql_connect("localhost", "root", "", "company_profile");

if (!$conn){
    http_response_code(500);
    echo json_decode(["status" => "error", "message" => "Koneksi gagal"]);
    exit();
}

?>