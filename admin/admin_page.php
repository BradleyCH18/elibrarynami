<?php
include '../config.php';

session_start(); 
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'admin';
}

$query = "SELECT * FROM buku";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Perpustakaan Digital</title>
    <link rel="stylesheet" href="../css/home_page.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">
        <img src="../nami.jpg" alt="Logo">
    </div>

    <form class="search-bar" method="get" action="search.php">
        <input type="text" name="q" placeholder="Cari buku...">
        <button type="submit">Cari</button>
    </form>

    <div class="nav-actions">
        <button class="home-btn" onclick="location.href='../admin/admin_page.php'">Home</button>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <button class="tambah-btn" onclick="location.href='../crud/add.php'">+ Tambah Buku</button>
        <?php endif; ?>
        <button class="logout-btn" onclick="location.href='../logout.php'">Logout</button>
    </div>
</nav>

<h3>Selamat Datang, <?= htmlspecialchars($_SESSION['nama']); ?> Telah Login Sebagai Admin</h3>

<div class="book-grid">
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <div class="book-card">
            <img src="../uploads/<?php echo $row['cover']; ?>" alt="Cover Buku">
            <h3><?php echo $row['judul']; ?></h3>
            <p><strong>Penulis:</strong> <?= $row['penulis']; ?></p>
            <p><strong>Rilis:</strong> <?= date('d M Y', strtotime($row['tanggal_rilis'])); ?></p>
            <div class="card-actions">
                <a href="../crud/edit.php?id=<?= $row['id']; ?>" class="edit-btn">Edit</a>
                <a href="../crud/delete.php?id=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('Yakin ingin hapus buku ini?')">Hapus</a>
                <a href="../uploads/<?= $row['file_buku']; ?>" class="download-btn" download>Download</a>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<footer style="margin-top: 50px; text-align: center; color: #ccc; font-size: 14px; padding: 20px 10px;">
    <hr style="border: none; border-top: 1px solid #555; margin: 20px auto; max-width: 80%;">
    <p>&copy; <?= date("Y") ?> E-Perpus Nami. All rights reserved.</p>
    <p>Contact: <a href="mailto:syafiqsyadidulaz20@gmail.com" style="color: #66b2ff;">syafiqsyadidulaz20@gmail.com</a></p>
    <p>Instagram: <a href="https://instagram.com/ssyddlazmii" target="_blank" style="color: #66b2ff;">@ssyddlazmii</a></p>
</footer>

</body>
</html>
