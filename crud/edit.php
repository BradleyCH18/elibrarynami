<?php
include '../config.php';

session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = mysqli_query($conn, "SELECT * FROM buku WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data buku tidak ditemukan.";
    exit();
}

if (isset($_POST['submit'])) {
    $judul = htmlspecialchars($_POST['judul']);
    $penulis = htmlspecialchars($_POST['penulis']);
    $tanggal_rilis = $_POST['tanggal_rilis'];

    $file_buku = $data['file_buku'];
    $cover = $data['cover'];

    if (!empty($_FILES['file_buku']['name'])) {
        $file_buku = $_FILES['file_buku']['name'];
        move_uploaded_file($_FILES['file_buku']['tmp_name'], "../uploads/" . $file_buku);
    }

    if (!empty($_FILES['cover']['name'])) {
        $cover = $_FILES['cover']['name'];
        move_uploaded_file($_FILES['cover']['tmp_name'], "../uploads/" . $cover);
    }

    $update = "UPDATE buku SET 
                judul='$judul', 
                penulis='$penulis', 
                tanggal_rilis='$tanggal_rilis', 
                file_buku='$file_buku', 
                cover='$cover' 
               WHERE id=$id";

    mysqli_query($conn, $update);
    header("Location: ../admin/admin_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Buku</title>
  <link rel="stylesheet" href="../css/edit.css">
</head>
<body>

<form method="post" enctype="multipart/form-data">
  <h2>Edit Buku</h2>

  <label for="judul">Judul Buku</label>
  <input type="text" name="judul" id="judul" value="<?= htmlspecialchars($data['judul']) ?>" required>

  <label for="penulis">Penulis</label>
  <input type="text" name="penulis" id="penulis" value="<?= htmlspecialchars($data['penulis']) ?>" required>

  <label for="tanggal_rilis">Tanggal Rilis</label>
  <input type="date" name="tanggal_rilis" id="tanggal_rilis" value="<?= $data['tanggal_rilis'] ?>" required>

  <label for="file_buku">Ganti File Buku (PDF)</label>
  <input type="file" name="file_buku" id="file_buku" accept="application/pdf">

  <label for="cover">Ganti Cover (Gambar)</label>
  <input type="file" name="cover" id="cover" accept="image/*">

  <button type="submit" name="submit">Simpan Perubahan</button>
  <a href="../admin/admin_page.php" class="back-btn">Kembali</a>
</form>

</body>
</html>
