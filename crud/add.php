<?php
include '../config.php';

if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tanggal_rilis = $_POST['tanggal_rilis'];

    $file_buku = $_FILES['file_buku']['name'];
    $cover = $_FILES['cover']['name'];

    $file_tmp = $_FILES['file_buku']['tmp_name'];
    $cover_tmp = $_FILES['cover']['tmp_name'];

    move_uploaded_file($file_tmp, "../uploads/" . $file_buku);
    move_uploaded_file($cover_tmp, "../uploads/" . $cover);

    $query = "INSERT INTO buku (judul, penulis, tanggal_rilis, file_buku, cover)
              VALUES ('$judul', '$penulis', '$tanggal_rilis', '$file_buku', '$cover')";

    mysqli_query($conn, $query);
    header("Location: ../admin/admin_page.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Buku</title>
  <link rel="stylesheet" href="../css/add.css">
</head>
<body>
  <form method="post" enctype="multipart/form-data">
    <h2>Tambah Buku</h2>

    <label for="judul">Judul Buku</label>
    <input type="text" name="judul" id="judul" required>

    <label for="penulis">Penulis</label>
    <input type="text" name="penulis" id="penulis" required>

    <label for="tanggal_rilis">Tanggal Rilis</label>
    <input type="date" name="tanggal_rilis" id="tanggal_rilis" required>

    <label for="file_buku">File Buku (PDF)</label>
    <input type="file" name="file_buku" id="file_buku" accept="application/pdf" required>

    <label for="cover">Cover Buku (Gambar)</label>
    <input type="file" name="cover" id="cover" accept="image/*" required>

    <button type="submit" name="submit">Tambah</button>
    <a href="../admin/admin_page.php" class="back-btn">Kembali</a>
  </form>
</body>
</html>
