<?php
header('Content-Type: application/json');
require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$uploadDir = 'uploads/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $result = $conn->query("SELECT * FROM coffees WHERE id = $id");
            echo json_encode($result->fetch_assoc());
        } else {
            $result = $conn->query("SELECT * FROM coffees ORDER BY id DESC");
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
        }
        break;

    case 'POST':
        $id = intval($_POST['id'] ?? 0);
        $name = $conn->real_escape_string($_POST['name'] ?? '');
        $desc = $conn->real_escape_string($_POST['description'] ?? '');
        $price = floatval($_POST['price'] ?? 0);
        $imageName = null;

        // Cek upload gambar baru
        if (!empty($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array(strtolower($ext), $allowedExt)) {
                echo json_encode(["error" => "Format gambar tidak didukung"]);
                exit;
            }

            $imageName = uniqid() . '.' . $ext;
            $uploadPath = $uploadDir . $imageName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                echo json_encode(["error" => "Gagal upload gambar"]);
                exit;
            }
        }

        if ($id > 0) {
            // === UPDATE ===
            $oldData = $conn->query("SELECT image FROM coffees WHERE id = $id");
            $old = $oldData->fetch_assoc();
            $oldImage = $old['image'] ?? null;

            if ($imageName && $oldImage && file_exists($uploadDir . $oldImage)) {
                unlink($uploadDir . $oldImage);
            } else {
                $imageName = $oldImage;
            }

            $update = $conn->query("UPDATE coffees 
                SET name='$name', description='$desc', price=$price, image='$imageName'
                WHERE id=$id");

            echo $update
                ? json_encode(["message" => "Produk berhasil diperbarui"])
                : json_encode(["error" => $conn->error]);

        } else {
            // === INSERT ===
            $insert = $conn->query("INSERT INTO coffees (name, description, price, image) 
                                    VALUES ('$name', '$desc', $price, '$imageName')");

            echo $insert
                ? json_encode(["message" => "Produk berhasil ditambahkan"])
                : json_encode(["error" => $conn->error]);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $data);
        $id = intval($data['id'] ?? 0);

        if ($id > 0) {
            $res = $conn->query("SELECT image FROM coffees WHERE id = $id");
            $imgData = $res->fetch_assoc();
            if ($imgData && $imgData['image']) {
                $imgPath = $uploadDir . $imgData['image'];
                if (file_exists($imgPath)) unlink($imgPath);
            }

            $delete = $conn->query("DELETE FROM coffees WHERE id = $id");

            echo $delete
                ? json_encode(["message" => "Produk berhasil dihapus"])
                : json_encode(["error" => $conn->error]);
        } else {
            echo json_encode(["error" => "ID tidak valid"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Metode tidak diizinkan"]);
        break;
}
?>
