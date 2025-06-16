<?php
include '../config.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM buku WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (file_exists("../uploads/" . $data['file_buku'])) {
    unlink("../uploads/" . $data['file_buku']);
}
if (file_exists("../uploads/" . $data['cover'])) {
    unlink("../uploads/" . $data['cover']);
}

mysqli_query($conn, "DELETE FROM buku WHERE id = $id");

header("Location: ../admin/admin_page.php");
