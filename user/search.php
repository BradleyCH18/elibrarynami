<?php
include '../config.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

$keyword = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';

$query = "SELECT * FROM buku 
          WHERE judul LIKE '%$keyword%' 
          OR penulis LIKE '%$keyword%' 
          ORDER BY tanggal_rilis DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pencarian</title>
    <link rel="stylesheet" href="../css/home_page.css">
    <link rel="stylesheet" href="../css/user.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">
        <img src="../nami.jpg" alt="Logo" style="height: 40px;">
    </div>

    <form class="search-bar" method="get" action="search.php">
        <input type="text" name="q" placeholder="Cari buku..." value="<?= htmlspecialchars($keyword) ?>" />
        <button type="submit">Cari</button>
    </form>

    <div class="nav-actions">
        <button class="home-btn" onclick="location.href='../user/user_page.php'">Home</button>
        
        <button class="logout-btn" onclick="location.href='../logout.php'">Logout</button>
</nav>

<h3>Hasil Pencarian: <?= htmlspecialchars($keyword) ?></h3>

<div class="book-grid">
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="book-card">
                <img src="../uploads/<?= $row['cover'] ?>" alt="Cover Buku">
                <div class="card-actions">
                    <h2><?= htmlspecialchars($row['judul']) ?></h2>
                    <p><strong>Penulis:</strong> <?= htmlspecialchars($row['penulis']) ?></p>
                    <p><strong>Rilis:</strong> <?= date('d M Y', strtotime($row['tanggal_rilis'])) ?></p>
                    <a href="../uploads/<?= $row['file_buku'] ?>" class="download-btn" download>Download</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center; margin-top: 30px;">Tidak ada buku yang cocok dengan kata kunci "<strong><?= htmlspecialchars($keyword) ?></strong>".</p>
    <?php endif; ?>
</div>

</body>
</html>
