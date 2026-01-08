<?php 
include 'includes/cek_login.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Menu Utama - Perpus Insight</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .portal-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            padding: 40px;
            max-width: 1100px;
            margin: auto;
        }
        .menu-card {
            background: white; border-radius: 24px; padding: 40px 20px;
            text-align: center; text-decoration: none; color: #1e293b;
            transition: all 0.3s ease; border: 2px solid transparent;
            display: flex; flex-direction: column; align-items: center;
        }
        .menu-card:hover { transform: translateY(-10px); border-color: var(--primary); box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
        .icon-circle { font-size: 50px; margin-bottom: 20px; background: #f1f5f9; width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; border-radius: 50%; }
    </style>
</head>
<body class="bg-soft">

    <div class="dash-header">
        <div class="brand">
            <h2>Perpus Insight</h2>
            <span class="badge-library">Portal Layanan</span>
        </div>
        <nav class="dash-nav">
            <?php if($_SESSION['level'] == 'admin'): ?>
                <a href="dashboard.php" class="nav-link">📊 Dashboard Monitoring</a>
            <?php endif; ?>
            <a href="logout.php" class="nav-link logout">🚪 Logout</a>
        </nav>
    </div>

    <div style="text-align: center; margin-top: 50px;">
        <h1 style="font-weight: 800; color: var(--dark);">Selamat Datang, <?= $_SESSION['nama'] ?></h1>
        <p style="color: #64748b;">Pilih modul layanan untuk diaktifkan di perangkat ini</p>
    </div>

    <div class="portal-grid">
        <a href="index.php" class="menu-card">
            <div class="icon-circle">📋</div>
            <h3>Sistem Kunjungan</h3>
            <p>Pencatatan pengunjung harian dengan kartu RFID.</p>
        </a>

        <a href="rekomendasi.php" class="menu-card">
            <div class="icon-circle">📚</div>
            <h3>Rekomendasi Buku</h3>
            <p>Daftar buku pilihan untuk referensi pengunjung.</p>
        </a>

        <a href="survei.php" class="menu-card">
            <div class="icon-circle">📝</div>
            <h3>Survei Kepuasan</h3>
            <p>Pengisian kuesioner layanan bagi pengunjung.</p>
        </a>
    </div>

</body>
</html>