<?php
include '../config.php';

$id = $_POST['id'];
$title = $_POST['title'];
$thumb = $_POST['thumbnail'];
$content = json_encode($_POST['content']);
$query = mysqli_query($conn, "UPDATE blog SET  title='$title',thumbnail='$thumb', content='$content' WHERE id=$id");
header("Location: ../views/list.php");
?>